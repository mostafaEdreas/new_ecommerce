<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\WishlistPaid;
use DB;
use File;
use Image;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Delivery;
use Illuminate\Http\Request;

use App\Models\Notification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

use App\Models\Setting;
use App\Traits\SMSTrait;


class OrderController extends Controller
{

    use SMSTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware(['permission:orders']);
    }

    public function index()
    {
        $orders = Order::with(['user','address'])->orderBy('id','desc')->get();
        return view('admin.orders.orders',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.colors.addColor');
    }
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $order=Order::with('products.group')->find($id);
        if($order){
            $order->admin_seen = 1;
            $order->save();

            $orderProducts=OrderProduct::where('order_id',$id)->get();

            ///////// order tracking operations///////////
            $statuses=['pending','accept','process','shipping','delivered','canceled'];
            $orderStatuses=OrderStatus::where('order_id',$id)->pluck('status')->toArray();
            $newActions =array_values(array_diff($statuses,$orderStatuses));

            $orderStatus = OrderStatus::where('order_id',$id)->get();
            $deliveries = Delivery::where('status','active')->get();

            return view('admin.orders.editOrder',compact('order','orderProducts','orderStatuses','newActions','orderStatus','deliveries'));
        }else{
            abort('404');
        }
    }


    public function update(Request $request, $id)
    {
    }


    public function destroy($ids)
    {
        //
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }

        $order = Order::whereIn('id',$ids)->CheckBeforDelete()->get();
        // dd($categories, $ids);
        if(count($order) > 0){
            if (request()->ajax()) {
                return response()->json(['message'=>__('home.the item cannot be deleted. There is data related to it')],402);
            }
            return redirect()->back()->withErrors(__('home.the item cannot be deleted. There is data related to it'));
        }
        foreach ($ids as $id) {
            Order::findOrFail($id)->delete();
        }
    }


    public function changeOrderStatus(){
        $orderId = $_POST['orderId'];
        $status = $_POST['status'];

        $order = Order::find($orderId);
        if($status == 'delivered'){
            $order->payment_status = 'paid';
            $order->save();
        }

        $order =Order::find($orderId);
        $order->status = $status;
        $order->save();


        ////////create invoice when order status changed to accept///////
        // $status_to_print = array('accept','pending','process','shipping');
        // if(in_array($status,$status_to_print) ){
        //     $lastInvoice=Invoice::orderBy('id','DESC')->first();
        //     $invoice=new Invoice();
        //     if($lastInvoice){
        //         $invoice->number=$lastInvoice->number + 1;
        //     }else{
        //         $invoice->number=10000;
        //     }
        //     $invoice->order_id = $orderId;
        //     $invoice->save();
        // }

        $orderStatus = new OrderStatus();
        $orderStatus ->order_id = $orderId;
        $orderStatus ->status = $status;

        $orderStatus->save();
        $orderStatuses= OrderStatus::where('order_id',$orderId)->pluck('status')->toArray();
        if($orderStatus = 'accept' && in_array('canceled_by_admin', $orderStatuses) ){
           OrderStatus::where('order_id',$orderId)->where('status','canceled_by_admin')->delete();
        }


        $setting = Setting::first();
        /////send sms after shipping order////
        if($status == 'shipping'){
            $this->SendMessage($order->address->phone1,$setting->shipping_order_msg);
        }

        /////send sms after delivered order////
        if($status == 'delivered'){
            $this->SendMessage($order->address->phone1,$setting->delivered_order_msg);
        }



        ////// send notification with new status/////
        $notification= new Notification();
        $notification->user_id=$order->user_id;
        $notification->type_value_id=$order->id;
        $notification->type='order_status';
        $notification->title= 'تغير حالة الطلب الخاص بك';
        $notification->text='طلبك رقم '.$order->id.'تم تغير حالتة الي '.$order->status;
        $notification->save();

        $this->pushNotification(User::find($order->user_id)->remember_token , $notification->title , $notification->text);





        // $notificationsCount = Notification::where('user_id',$order->user_id)->where('seen',0)->count();

        // $optionBuilder = new OptionsBuilder();
        // $optionBuilder->setTimeToLive(60*20);

        // $notificationBuilder = new PayloadNotificationBuilder($notification->title);
        // $notificationBuilder->setBody($notification->text)->setSound('default')->setClickAction("ReceiveActivity")->setBadge($notificationsCount);
        // $dataBuilder = new PayloadDataBuilder();
        // $dataBuilder->addData(['order_id' => $order->id ,'user_id'=>$order->user_id,'badge'=>$notificationsCount]);

        // $option = $optionBuilder->build();
        // $notification = $notificationBuilder->build();
        // $data = $dataBuilder->build();

        // // You must change it to get your tokens
        // $tokens = User::where('id',$order->user_id)->pluck('remember_token')->toArray();

        // //dd($tokens, $option, $notification, $data);
        // $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        // $downstreamResponse->numberSuccess();
        // $downstreamResponse->numberFailure();
        // $downstreamResponse->numberModification();

        // // return Array - you must remove all this tokens in your database
        // $downstreamResponse->tokensToDelete();

        // // return Array (key : oldToken, value : new token - you must change the token in your database)
        // $downstreamResponse->tokensToModify();

        // // return Array - you should try to resend the message to the tokens in the array
        // $downstreamResponse->tokensToRetry();

        // // return Array (key:token, value:error) - in production you should remove from your database the tokens present in this array
        // $downstreamResponse->tokensWithError();

    }


    public function pushNotification($token , $title, $body){
        define( 'API_ACCESS_KEY', 'AAAAouF7Fp0:APA91bFgti4nu6h58keC_XZfyW0HlrQoJROK0qDSGsUyAN5U5oCbR1EiX5nSjvU9mjOh85y3k3be0UOBIphoGnL3z9vS7OIP5a6CIo9QNroai0u8VVUKydQ51IjHfuPVzhYCDcxuax92' );

        $fcmUrl = 'httpsfcm.googleapis.comfcmsend';

        $notification = [
            'title' => $title,
            'body' => $body,
            'icon' => 'myIcon',
            'sound' => 'mySound'
        ];
        $extraNotificationData = ['message' => $notification,'moredata' =>'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'=> $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization key=' . API_ACCESS_KEY,
            'Content-Type applicationjson'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
    }

    /////////// function view order invioce////////////
    public function orderInvoice($id){
        $invoice = Invoice::Where('order_id',$id)->first();
        if($invoice){
            $orderProducts=OrderProduct::where('order_id',$id)->get();
            return view('admin.orders.invoice',compact('invoice','orderProducts'));
        }else{
            $orderId = $id;
            $order = Order::find($id);
            $status = $order->status;
            $status_to_print = array('accept','pending','process','shipping');
            if(in_array($status,$status_to_print) ){
                $lastInvoice=Invoice::orderBy('id','DESC')->first();
                $invoice=new Invoice();
                if($lastInvoice){
                    $invoice->number=$lastInvoice->number + 1;
                }else{
                    $invoice->number=10000;
                }
                $invoice->order_id = $orderId;
                $invoice->save();
            }else{
                abort('404');
            }
            if($invoice){
            $orderProducts=OrderProduct::where('order_id',$id)->get();
            return view('admin.orders.invoice',compact('invoice','orderProducts'));
            }else{
                abort('404');
            }
        }

    }

    //////////// function order filter ////////////
    public function orderFilter(){
        $status = $_POST['status'];
        $dateFrom = $_POST['dateFrom'];
        $dateTo = $_POST['dateTo'];
        $from=date('Y-m-d H:i:s', strtotime($dateFrom." -1 days"));
        $to=date('Y-m-d H:i:s', strtotime($dateTo." +1 days"));

        //dd($status);
        $orders=Order::whereBetween('created_at', [$from, $to])->get();

        if($status){
            $orders = $orders->where('status',$status);
        }

        return response()->json([
            'html' => view('admin.orders.orderFilterResult', compact('orders'))->render(),
        ]);

    }

    public function OrderDelivey(Request $request,$id){
        $order = Order::find($id);
        $order->delivery_id = $request->delivery_id;
        $order->delivery_date = $request->delivery_date;
        $order->save();
        return back()->with('success',trans('home.delivery time added successfully'));
    }


    public function orderCancel($id){
        $order = Order::find($id);
        foreach ($order->products() as $product){
                WishlistPaid::where('user_id_buyer',$order->user_id)
                    ->where('product_id',$product->product_id)
                    ->update(['user_id_buyer'=>null,'status'=>null,'done'=>false]);
        }
        $order->status = 'canceled_by_admin';
        $order->save();
        $orderStatus = new OrderStatus();
        $orderStatus ->order_id = $id;
        $orderStatus ->status = 'canceled_by_admin';
        $orderStatus->save();
        $orderStatuses= OrderStatus::where('order_id',$id)->pluck('status')->toArray();
        if($orderStatus = 'canceled_by_admin' && in_array('accept', $orderStatuses) ){
           OrderStatus::where('order_id',$id)->where('status','accept')->delete();
        }

        return back()->with('success',trans('home.order canceled succesfully'));
    }

}
