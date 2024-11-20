<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Region;
use DB;
use Session;
use App\Models\User;
use App\Models\Coupon;
use App\Models\PaymentMethod;
use App\Models\Invoice;
use App\Models\Outsource;
use App\Models\OutsourceInvoice;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ShippingMethod;
use Carbon\Carbon;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    ///////////////////// function return view of order report ///////////////////////////////
    public function orderReportView(){
        $brands=Brand::where('status',1)->get();
        $categories=Category::where('status',1)->get();
        $paymentMethods=PaymentMethod::where('status',1)->get();
        $shippingMethods=ShippingMethod::where('status',1)->get();
        $products = Product::where('status',1)->select('name_en','name_ar', 'id')->get();
        $regions = Region::where('status', 1)->get();

        return view('admin.reports.orderReport.orderReport',compact('regions','products','brands','categories','paymentMethods','shippingMethods'));
    }

    ///////////// function return result using ajax generate  order report////////////////////
    public function orderReportResult(){

        $brandId=$_POST['brandId'];
        $productId=$_POST['productId'];
        $categoryId=$_POST['categoryId'];
        $paymentId=$_POST['paymentId'];
        $shippingId=$_POST['shippingId'];
        $regionId=$_POST['regionId'];
        $dateFrom=$_POST['dateFrom'];
        $dateTo=$_POST['dateTo'];
        $from=date('Y-m-d H:i:s', strtotime($dateFrom." -1 days"));
        $to=date('Y-m-d H:i:s', strtotime($dateTo." +1 days"));

        if($brandId=='' && $categoryId=='' && $paymentId== '' && $shippingId=='' && $productId==''){
            $orders=Order::whereBetween('created_at', [$from, $to])->get();
            return response()->json([
                'html' => view('admin.reports.orderReport.orderReportResult', compact('orders','dateFrom','dateTo'))->render(),
            ]);
        }

        if($brandId && $categoryId=='' && $paymentId== '' && $shippingId=='' && $productId==''){
            $brandProductIds=Stock::whereHas('product',function($product_query)use($brandId){
                $product_query->where('brand_id',$brandId);
            })->pluck('id')->toArray();
            $orderIDs = OrderProduct::whereIn('group_id',$brandProductIds)->pluck('order_id')->toArray();
            $orders=Order::whereBetween('created_at', [$from, $to])->whereIn('id',$orderIDs)->get();
            return response()->json([
                'html' => view('admin.reports.orderReport.orderReportResult', compact('orders','dateFrom','dateTo'))->render(),
            ]);
        }

        if($brandId=='' && $categoryId && $paymentId== '' && $shippingId=='' && $productId==''){

            // $categoryProductIds=Product::where('category_id',$categoryId)->pluck('id')->toArray();
            $categoryProductIds=Stock::whereHas('product',function($product_query)use($categoryId){
                $product_query->where('category_id',$categoryId);
            })->pluck('id')->toArray();
            $orderIDs = OrderProduct::whereIn('group_id',$categoryProductIds)->pluck('order_id')->toArray();
            $orders=Order::whereBetween('created_at', [$from, $to])->whereIn('id',$orderIDs)->get();
            return response()->json([
                'html' => view('admin.reports.orderReport.orderReportResult', compact('orders','dateFrom','dateTo'))->render(),
            ]);
        }

        if($brandId=='' && $categoryId=='' && $paymentId && $shippingId=='' && $productId==''){

            $orders=Order::whereBetween('created_at', [$from, $to])->where('payment_id',$paymentId)->get();
            return response()->json([
                'html' => view('admin.reports.orderReport.orderReportResult', compact('orders','dateFrom','dateTo'))->render(),
            ]);
        }

        if($brandId=='' && $categoryId=='' && $paymentId=='' && $shippingId && $productId==''){

            $orders=Order::whereBetween('created_at', [$from, $to])->where('shipping_id',$shippingId)->get();
            return response()->json([
                'html' => view('admin.reports.orderReport.orderReportResult', compact('orders','dateFrom','dateTo'))->render(),
            ]);
        }


        if($brandId && $categoryId && $paymentId== '' && $shippingId=='' && $productId==''){

            // $ProductIds=Product::where('brand_id',$brandId)->where('category_id',$categoryId)->pluck('id')->toArray();
            $ProductIds=Stock::whereHas('product',function($product_query)use($categoryId){
                $product_query->where('category_id',$categoryId);
            })->whereHas('product',function($product_query)use($brandId){
                $product_query->where('brand_id',$brandId);
            })->pluck('id')->toArray();

            $orderIDs = OrderProduct::whereIn('group_id',$ProductIds)->pluck('order_id')->toArray();
            $orders=Order::whereBetween('created_at', [$from, $to])->whereIn('id',$orderIDs)->get();
            return response()->json([
                'html' => view('admin.reports.orderReport.orderReportResult', compact('orders','dateFrom','dateTo'))->render(),
            ]);
        }


        if($brandId=='' && $categoryId=='' && $paymentId && $shippingId  && $productId==''){

            $orders=Order::whereBetween('created_at', [$from, $to])->where('payment_id',$paymentId)->where('shipping_id',$shippingId)->get();
            return response()->json([
                'html' => view('admin.reports.orderReport.orderReportResult', compact('orders','dateFrom','dateTo'))->render(),
            ]);
        }


        if($brandId && $categoryId && $paymentId && $shippingId  && $productId==''){

            // $ProductIds=Product::where('brand_id',$brandId)->where('category_id',$categoryId)->pluck('id')->toArray();
            // $orderIDs = OrderProduct::whereIn('product_id',$ProductIds)->pluck('order_id')->toArray();
            $ProductIds=Stock::whereHas('product',function($product_query)use($categoryId){
                $product_query->where('category_id',$categoryId);
            })->whereHas('product',function($product_query)use($brandId){
                $product_query->where('brand_id',$brandId);
            })->pluck('id')->toArray();

            $orderIDs = OrderProduct::whereIn('group_id',$ProductIds)->pluck('order_id')->toArray();
            $orders=Order::whereBetween('created_at', [$from, $to])->whereIn('id',$orderIDs)->where('payment_id',$paymentId)->where('shipping_id',$shippingId)->get();

            return response()->json([
                'html' => view('admin.reports.orderReport.orderReportResult', compact('orders','dateFrom','dateTo'))->render(),
            ]);
        }
        if($brandId=='' && $categoryId=='' && $paymentId=='' && $shippingId==''  && $productId==''){

            // $ProductIds=Product::where('brand_id',$brandId)->where('category_id',$categoryId)->pluck('id')->toArray();
            // $orderIDs = OrderProduct::whereIn('product_id',$ProductIds)->pluck('order_id')->toArray();
            $ProductIds=Stock::whereHas('product',function($product_query)use($categoryId){
                $product_query->where('category_id',$categoryId);
            })->whereHas('product',function($product_query)use($brandId){
                $product_query->where('brand_id',$brandId);
            })->pluck('id')->toArray();

            $orderIDs = OrderProduct::whereIn('group_id',$ProductIds)->pluck('order_id')->toArray();
            $orders=Order::whereBetween('created_at', [$from, $to])->whereIn('id',$orderIDs)->where('payment_id',$paymentId)->where('shipping_id',$shippingId)->get();

            return response()->json([
                'html' => view('admin.reports.orderReport.orderReportResult', compact('orders','dateFrom','dateTo'))->render(),
            ]);
        }
        if($brandId=='' && $categoryId=='' && $paymentId=='' && $shippingId==''  && $productId){

//            $ProductIds=Product::where('brand_id',$brandId)->where('category_id',$categoryId)->pluck('id')->toArray();
            $stockIds = Stock::where('product_id',$productId)->pluck('id')->toArray();
            $orderIDs = OrderProduct::whereIn('group_id',$stockIds)->pluck('order_id')->toArray();
            $orders=Order::whereBetween('created_at', [$from, $to])->whereIn('id',$orderIDs)->get();

            return response()->json([
                'html' => view('admin.reports.orderReport.orderReportResult', compact('orders','dateFrom','dateTo'))->render(),
            ]);
        }


    }


    ///////////// function return viewe of Daily Report///////////////////////////////////////

    public function dailyReportView(){
        return view('admin.reports.dailyReport.dailyReport');
    }

    ///////////// function return result ajax dailyReportResult ///////////////////////////////

    public function dailyReportResult(){
        $date=$_POST['date'];
        $orders=Order::whereDate('created_at', '=', $date)->get();
        return response()->json([
            'html' => view('admin.reports.dailyReport.dailyReportResult', compact('orders','date'))->render(),
        ]);
    }


    ///////////// function return viewe of monthely Report///////////////////////////////////////

    public function monthelyReportView(){
        return view('admin.reports.monthelyReport.monthelyReport');
    }

    ///////////// function return result ajax monthelyReportResult ///////////////////////////////

    public function monthelyReportResult(){
        $month = substr($_POST['month'], 5);
        $year = substr($_POST['month'],0,4);
        $orders=Order::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
        return response()->json([
            'html' => view('admin.reports.monthelyReport.monthelyReportResult', compact('orders','month'))->render(),
        ]);
    }

    ///////////// function return viewe of weekly Report///////////////////////////////////////

    public function weeklyReportView(){
        return view('admin.reports.weeklyReport.weeklyReport');
    }

    ///////////// function return result ajax weeklyReportResult ///////////////////////////////
    public function weeklyReportResult(){
        $orders = Order::whereBetween('created_at', [Carbon::now()->subWeek()->format("Y-m-d H:i:s"), Carbon::now()])->get();
        return response()->json([
            'html' => view('admin.reports.weeklyReport.weeklyReportResult', compact('orders'))->render(),
        ]);
    }

    ///////////// function return viewe of product Report///////////////////////////////////////
    public function productReportView(){
        $products = Product::get();
        return view('admin.reports.productReport.productReport',compact('products'));
    }

    ///////////// function return result ajax productReportResult ///////////////////////////////
    public function productReportResult(){
        $product_id = $_POST['product_id'];
        $ordersProduct =OrderProduct::where('group_id',$product_id)->get();
        return response()->json([
            'html' => view('admin.reports.productReport.productReportResult', compact('ordersProduct'))->render(),
        ]);
    }

    ///////////// function return viewe of product Report///////////////////////////////////////
    public function ordersProductsReportView(){
        return view('admin.reports.orderProductsReport.orderProductsReport');
    }

    ///////////// function return result ajax productReportResult ///////////////////////////////
    public function ordersProductsReportResult(){


        $dateFrom=$_POST['dateFrom'];
        $dateTo=$_POST['dateTo'];
        $from=date('Y-m-d H:i:s', strtotime($dateFrom." -1 days"));
        $to=date('Y-m-d H:i:s', strtotime($dateTo." +1 days"));

        $ordersProducts =OrderProduct::whereBetween('created_at', [$from, $to])->select('group_id', DB::raw('count(group_id) as productCount'))->groupBy('group_id')->get();
        return response()->json([
            'html' => view('admin.reports.orderProductsReport.orderProductsReportResult', compact('ordersProducts','dateFrom','dateTo'))->render(),
        ]);
    }






























    ////////// function return view Generate coupon report /////////////

    public function couponReportView()
    {
        $regions=Region::all();
        return view('admin.reports.generateCouponReport.couponReport',compact('regions'));
    }
    ///////// function return result using ajax generate coupon report ///////

    public function couponReport(){
        $regionId=$_POST['regionId'];
        $dateFrom=$_POST['dateFrom'];
        $dateTo=$_POST['dateTo'];
        $valueUpTo=$_POST['valueUpTo'];
        $orderUpTo=$_POST['orderUpTo'];
        $form=date('Y-m-d H:i:s', strtotime($dateFrom));
        $to=date('Y-m-d H:i:s', strtotime($dateTo));

        if($regionId == '' && $valueUpTo == '' && $orderUpTo == ''){
            $users=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->select(DB::raw('sum(products_price) as total'),DB::raw('count(*) as Count'),'user_id','region_id','area_id')->groupBy('user_id')->get();
            $userIds=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->groupBy('user_id')->pluck('user_id')->toArray();
            session()->put('userIds',$userIds);

            return response()->json([
            'html' => view('admin.reports.generateCouponReport.couponReportResult', compact('users'))->render(),
        ]);
        }

        if($regionId && $valueUpTo=='' && $orderUpTo==''){
            $users=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->where('region_id',$regionId)->select(DB::raw('sum(products_price) as total'),DB::raw('count(*) as Count'),'user_id','region_id','area_id')->groupBy('user_id')->get();
            $userIds=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->where('region_id',$regionId)->groupBy('user_id')->pluck('user_id')->toArray();
            session()->put('userIds',$userIds);
            return response()->json([
            'html' => view('admin.reports.generateCouponReport.couponReportResult', compact('users'))->render(),
        ]);
        }

        if($regionId=='' && $valueUpTo && $orderUpTo==''){
            $users=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->select(DB::raw('sum(products_price) as total'),DB::raw('count(*) as Count'),'user_id','region_id','area_id')->groupBy('user_id')->having('total','>=',$valueUpTo)->get();
            $userIds=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->select(DB::raw('sum(products_price) as total'),'user_id')->groupBy('user_id')->having('total','>=',$valueUpTo)->pluck('user_id')->toArray();
            session()->put('userIds',$userIds);
            return response()->json([
            'html' => view('admin.reports.generateCouponReport.couponReportResult', compact('users'))->render(),
        ]);
        }

        if($regionId=='' && $valueUpTo=='' && $orderUpTo){
            $users=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->select(DB::raw('sum(products_price) as total'),DB::raw('count(*) as Count'),'user_id','region_id','area_id')->groupBy('user_id')->having('Count','>=',$orderUpTo)->get();
            $userIds=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->select(DB::raw('count(*) as Count'),'user_id')->groupBy('user_id')->having('Count','>=',$orderUpTo)->pluck('user_id')->toArray();
            session()->put('userIds',$userIds);
            return response()->json([
            'html' => view('admin.reports.generateCouponReport.couponReportResult', compact('users'))->render(),
        ]);
        }

        if($regionId && $valueUpTo && $orderUpTo==''){
            $users=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->where('region_id',$regionId)->select(DB::raw('sum(products_price) as total'),DB::raw('count(*) as Count'),'user_id','region_id','area_id')->groupBy('user_id')->having('total','>=',$valueUpTo)->get();
            $userIds=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->select(DB::raw('sum(products_price) as total'),'user_id')->where('region_id',$regionId)->groupBy('user_id')->having('total','>=',$valueUpTo)->pluck('user_id')->toArray();

            session()->put('userIds',$userIds);
            return response()->json([
            'html' => view('admin.reports.generateCouponReport.couponReportResult', compact('users'))->render(),
        ]);
        }

        if($regionId && $valueUpTo=='' && $orderUpTo){
            $users=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->where('region_id',$regionId)->select(DB::raw('sum(products_price) as total'),DB::raw('count(*) as Count'),'user_id','region_id','area_id')->groupBy('user_id')->having('Count','>=',$orderUpTo)->get();
            $userIds=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->select(DB::raw('count(*) as Count'),'user_id')->where('region_id',$regionId)->groupBy('user_id')->having('Count','>=',$orderUpTo)->pluck('user_id')->toArray();
            session()->put('userIds',$userIds);
            return response()->json([
            'html' => view('admin.reports.generateCouponReport.couponReportResult', compact('users'))->render(),
        ]);
        }

        if($regionId=='' && $valueUpTo && $orderUpTo){
            $users=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->select(DB::raw('sum(products_price) as total'),DB::raw('count(*) as Count'),'user_id','region_id','area_id')->groupBy('user_id')->having('Count','>=',$orderUpTo)->having('total','>=',$valueUpTo)->get();
            $userIds=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->select(DB::raw('count(*) as Count'),DB::raw('sum(products_price) as total'),'user_id')->groupBy('user_id')->having('Count','>=',$orderUpTo)->having('total','>=',$valueUpTo)->pluck('user_id')->toArray();
            session()->put('userIds',$userIds);
            return response()->json([
            'html' => view('admin.reports.generateCouponReport.couponReportResult', compact('users'))->render(),
        ]);
        }

        if($regionId && $valueUpTo && $orderUpTo){
            $users=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->where('region_id',$regionId)->select(DB::raw('sum(products_price) as total'),DB::raw('count(*) as Count'),'user_id','region_id','area_id')->groupBy('user_id')->having('Count','>=',$orderUpTo)->having('total','>=',$valueUpTo)->get();
            $userIds=Order::whereBetween('created_at', [$form, $to])->where('status','Deliverd')->select(DB::raw('count(*) as Count'),DB::raw('sum(products_price) as total'),'user_id')->where('region_id',$regionId)->groupBy('user_id')->having('Count','>=',$orderUpTo)->having('total','>=',$valueUpTo)->pluck('user_id')->toArray();
            session()->put('userIds',$userIds);
            return response()->json([
            'html' => view('admin.reports.generateCouponReport.couponReportResult', compact('users'))->render(),
        ]);
        }
    }

    ////////// function return view user coupon report /////////////

    public function userCouponReportView()
    {
        $users=User::all();
        $coupons=Coupon::all();
        return view('admin.reports.userCouponReport.userCouponReport',compact('users','coupons'));
    }

    ///////// function return result using ajax generate user coupon report ///////
    public function userCouponReport(){
        $couponId=$_POST['couponId'];
        $userId=$_POST['userId'];
        $dateFrom=$_POST['dateFrom'];
        $dateTo=$_POST['dateTo'];
        $form=date('Y-m-d H:i:s', strtotime($dateFrom));
        $to=date('Y-m-d H:i:s', strtotime($dateTo));

        if($couponId=='' && $userId==''){
            $users=Order::whereBetween('created_at', [$form, $to])->select(DB::raw('sum(products_price) as total'),DB::raw('sum(coupoun_discount) as coupon_discount'),DB::raw('count(coupon_id) as Count'),'user_id','coupon_id')->groupBy('coupon_id')->get();
            $couponTotalDiscount=[];
            $couponCount=[];
            foreach($users as $user){
                array_push($couponTotalDiscount,$user->coupon_discount);
                array_push($couponCount,$user->Count);
            }
            $total=array_sum($couponTotalDiscount);
            $totalCount=array_sum($couponCount);
            return response()->json([
            'html' => view('admin.reports.userCouponReport.ReportResult', compact('users','total','totalCount'))->render(),
        ]);
        }

        if($couponId && $userId==''){
            $users=Order::whereBetween('created_at', [$form, $to])->where('coupon_id',$couponId)->select(DB::raw('sum(products_price) as total'),DB::raw('sum(coupoun_discount) as coupon_discount'),DB::raw('count(coupon_id) as Count'),'user_id','coupon_id')->groupBy('user_id')->get();
            $couponTotalDiscount=[];
            $couponCount=[];
            foreach($users as $user){
                array_push($couponTotalDiscount,$user->coupon_discount);
                array_push($couponCount,$user->Count);
            }
            $total=array_sum($couponTotalDiscount);
            $totalCount=array_sum($couponCount);
            return response()->json([
            'html' => view('admin.reports.userCouponReport.ReportResult', compact('users','total','totalCount'))->render(),
        ]);
        }

        if($couponId=='' && $userId){
            $users=Order::whereBetween('created_at', [$form, $to])->where('user_id',$userId)->select(DB::raw('sum(products_price) as total'),DB::raw('sum(coupoun_discount) as coupon_discount'),DB::raw('count(coupon_id) as Count'),'user_id','coupon_id')->groupBy('coupon_id')->get();
            $couponTotalDiscount=[];
            $couponCount=[];
            foreach($users as $user){
                array_push($couponTotalDiscount,$user->coupon_discount);
                array_push($couponCount,$user->Count);
            }
            $total=array_sum($couponTotalDiscount);
            $totalCount=array_sum($couponCount);
            return response()->json([
            'html' => view('admin.reports.userCouponReport.ReportResult', compact('users','total','totalCount'))->render(),
        ]);
        }

        if($couponId && $userId){
            $users=Order::whereBetween('created_at', [$form, $to])->where('user_id',$userId)->where('coupon_id',$couponId)->select(DB::raw('sum(products_price) as total'),DB::raw('sum(coupoun_discount) as coupon_discount'),DB::raw('count(coupon_id) as Count'),'user_id','coupon_id')->groupBy('coupon_id')->get();
            $couponTotalDiscount=[];
            $couponCount=[];
            foreach($users as $user){
                array_push($couponTotalDiscount,$user->coupon_discount);
                array_push($couponCount,$user->Count);
            }
            $total=array_sum($couponTotalDiscount);
            $totalCount=array_sum($couponCount);
            return response()->json([
            'html' => view('admin.reports.userCouponReport.ReportResult', compact('users','total','totalCount'))->render(),
        ]);
        }
    }

    ////////// function return view user coupon report /////////////

    public function generalCouponReportView()
    {
        $coupons=Coupon::all();
        return view('admin.reports.generalCouponReport.couponReport',compact('coupons'));
    }

    ///////// function return result using ajax generate user coupon report ///////
    public function generalCouponReport(){
        $couponId=$_POST['couponId'];
        $dateFrom=$_POST['dateFrom'];
        $dateTo=$_POST['dateTo'];
        $form=date('Y-m-d H:i:s', strtotime($dateFrom));
        $to=date('Y-m-d H:i:s', strtotime($dateTo));

        if($couponId){
            $coupons=Order::whereBetween('created_at', [$form, $to])->where('coupon_id',$couponId)->select(DB::raw('sum(products_price) as total'),DB::raw('sum(coupoun_discount) as coupon_discount'),DB::raw('count(coupon_id) as Count'),'coupon_id')->groupBy('coupon_id')->get();
            dd($coupons);
            return response()->json([
            'html' => view('admin.reports.userCouponReport.ReportResult', compact('coupons'))->render(),
        ]);
        }
    }
///////////////////////// function return view acoountig report/////////////////

    public function accountingReportView(){
        $paymentMethods=PaymentMethods::where('status',1)->get();

         return view('admin.reports.accountingReport.invoicesReport',compact('paymentMethods'));
    }

   ///////// function return result using ajax generate  report ///////
    public function accountingReport(){
        $status=$_POST['status'];
        $paymentMethodId=$_POST['paymentMethodId'];
        $dateFrom=$_POST['dateFrom'];
        $dateTo=$_POST['dateTo'];
        $from=date('Y-m-d H:i:s', strtotime($dateFrom." -1 days"));
        $to=date('Y-m-d H:i:s', strtotime($dateTo." +1 days"));

        if($paymentMethodId=='' && $status==''){
            $invoices=Invoice::whereBetween('created_at', [$from, $to])->get();
            return response()->json([
            'html' => view('admin.reports.accountingReport.ReportResult', compact('invoices','from','to'))->render(),
        ]);
        }

        if($paymentMethodId && $status){
            $invoices=Invoice::whereBetween('created_at', [$from, $to])->where('payment_method_id',$paymentMethodId)->where('status',$status)->get();
            return response()->json([
            'html' => view('admin.reports.accountingReport.ReportResult', compact('invoices','from','to'))->render(),
        ]);
        }

        if($paymentMethodId=='' && $status){
            $invoices=Invoice::whereBetween('created_at', [$from, $to])->where('status',$status)->get();
            return response()->json([
            'html' => view('admin.reports.accountingReport.ReportResult', compact('invoices','from','to'))->render(),
        ]);
        }

        if($paymentMethodId && $status==''){
            $invoices=Invoice::whereBetween('created_at', [$from, $to])->where('payment_method_id',$paymentMethodId)->get();
            return response()->json([
            'html' => view('admin.reports.accountingReport.ReportResult', compact('invoices','from','to'))->render(),
        ]);
        }
    }
    ////////////// function return view outsourceInvoiceReport////////////////////////
    public function outsourceInvoiceReport(){
        $outsources = Outsource::all();
        return view('admin.reports.outsourceInvoiceReport.outsourceInvoiceReport',compact('outsources'));
    }

    ///////// function return result using ajax generate  outsourceInvoice report ///////
    public function outsourceInvoiceReportResult(){
        $status=$_POST['status'];
        $outsourceId=$_POST['outsourceId'];
        $dateFrom=$_POST['dateFrom'];
        $dateTo=$_POST['dateTo'];
        $from=date('Y-m-d H:i:s', strtotime($dateFrom." -1 days"));
        $to=date('Y-m-d H:i:s', strtotime($dateTo." +1 days"));

        if($outsourceId=='' && $status==''){
            $invoices=OutsourceInvoice::whereBetween('created_at', [$from, $to])->get();
            $invoiceTotal=OutsourceInvoice::whereBetween('created_at', [$from, $to])->select(DB::raw('sum(our_price) as our_price'),DB::raw('sum(selling_price * quantity) as selling_price'))->get();
            return response()->json([
            'html' => view('admin.reports.outsourceInvoiceReport.ReportResult', compact('invoices','invoiceTotal','from','to'))->render(),
        ]);
        }

        if($outsourceId && $status){
            $invoices=OutsourceInvoice::whereBetween('created_at', [$from, $to])->where('outsource_id',$outsourceId)->where('status',$status)->get();
            $invoiceTotal=OutsourceInvoice::whereBetween('created_at', [$from, $to])->where('outsource_id',$outsourceId)->where('status',$status)->select(DB::raw('sum(our_price) as our_price'),DB::raw('sum(selling_price * quantity) as selling_price'))->get();
            return response()->json([
            'html' => view('admin.reports.outsourceInvoiceReport.ReportResult', compact('invoices','invoiceTotal','from','to'))->render(),
        ]);
        }

        if($outsourceId=='' && $status){
            $invoices=OutsourceInvoice::whereBetween('created_at', [$from, $to])->where('status',$status)->get();
            $invoiceTotal=OutsourceInvoice::whereBetween('created_at', [$from, $to])->where('status',$status)->select(DB::raw('sum(our_price) as our_price'),DB::raw('sum(selling_price * quantity) as selling_price'))->get();
            return response()->json([
            'html' => view('admin.reports.outsourceInvoiceReport.ReportResult', compact('invoices','invoiceTotal','from','to'))->render(),
        ]);
        }

        if($outsourceId && $status==''){
            $invoices=OutsourceInvoice::whereBetween('created_at', [$from, $to])->where('outsource_id',$outsourceId)->get();
            $invoiceTotal=OutsourceInvoice::whereBetween('created_at', [$from, $to])->where('outsource_id',$outsourceId)->select(DB::raw('sum(our_price) as our_price'),DB::raw('sum(selling_price * quantity) as selling_price'))->get();
            return response()->json([
            'html' => view('admin.reports.outsourceInvoiceReport.ReportResult', compact('invoices','invoiceTotal','from','to'))->render(),
        ]);
        }
    }

}
