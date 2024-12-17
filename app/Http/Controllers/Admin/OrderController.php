<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\WishlistPaid;
use App\Models\Invoice;
use App\Models\Delivery;
use Illuminate\Http\Request;

use App\Traits\SMSTrait;
use Carbon\Carbon;

class OrderController extends Controller
{

    use SMSTrait;


    public function __construct(){
        $this->middleware(['permission:orders']);
    }

    public function index()
    {
        $orders = Order::with(['user','address'])->orderBy('id','desc')->get();
        return view('admin.orders.orders',compact('orders'));
    }


    public function edit($id)
    {
        $data['order'] = Order::with(['productStock','products','orderStatus','status'])->find($id);
        if($data['order']){
            $data['order']->update(['admin_seen',1]);
            $data['newActions'] =array_values(array_diff(OrderStatus::STATUS,$data['order']->orderStatus->pluck('status')));
            $data['deliveries'] = Delivery::where('status','active')->get();
            return view('admin.orders.editOrder',$data);
        }else{
            abort('404');
        }
    }





    public function changeOrderStatus(){
        $orderId = request('orderId');
        $status =request('status');
        $note =request('note');
        $order = Order::find($orderId);
        if($order->status == 'delivered'){
            return redirect()->back()->withError(__('home.cannot change an order status that is delivered'));
        }

       

        if($status == 'canceled' && !$note ){
            return redirect()->back()->withError(__('home.you should write the reason for cancellation'));
        }

        if($status == 'accept' && !$note && $order->status == 'canceled'){
            return redirect()->back()->withError(__('home.you should write the reason for acceptance if the order is canceled later'));
        }
        if($status == 'shipping' && !$order->delivery_id){
            return redirect()->back()->withError(__('home.you need to assign a delivery person before the order can be shipped'));
        }
       
        if($status == 'delivered'){
            $order->payment_status = 'paid';
            $order->save();
        }

        $orderStatus = new OrderStatus();
        $orderStatus ->order_id = $orderId;
        $orderStatus ->status = $status;
        $orderStatus ->note = $note;
        $orderStatus->save();
    
        /////send sms after shipping order////
        // if($status == 'shipping'){
        //     $this->SendMessage($order->address->phone1 , config('site_shipping_order_msg'));
        // }

        // /////send sms after delivered order////
        // if($status == 'delivered'){
        //     $this->SendMessage($order->address->phone1,config('site_shipping_order_msg'));
        // }

        // ////// send notification with new status/////
        // $notification= new Notification();
        // $notification->user_id=$order->user_id;
        // $notification->type_value_id=$order->id;
        // $notification->type='order_status';
        // $notification->title= 'تغير حالة الطلب الخاص بك';
        // $notification->text='طلبك رقم '.$order->number.'تم تغير حالتة الي '.$order->status;
        // $notification->save();
        // $this->pushNotification(User::find($order->user_id)->remember_token , $notification->title , $notification->text);
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
        $orderNumber = request('order_number');
        $status = request('status');
        $dateFrom = request('dateFrom');
        $dateTo = request('dateTo');
        if($orderNumber){

            $orders = Order::where('status',$status)->get();

        }else{
            $orders = Order::query();
            if($dateFrom){

                $from = Carbon::parse($dateFrom)->startOfDay();
                $orders = $orders->where('created_at', '>=',$from);
            }
            if($dateTo){

                $to = Carbon::parse($dateTo)->startOfDay();
                $orders = $orders->where('created_at', '<=',$to);
            }
            
            if($status){
                $orders->where('status',$status);
            }

            $orders = $orders->get();

        }
       

        if(request()->ajax()){
            return response()->json([
                'html' => view('admin.orders.orderFilterResult', compact('orders'))->render(),
            ]);
        }else{
            return view('admin.orders.orders',compact('orders'));
        }
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
