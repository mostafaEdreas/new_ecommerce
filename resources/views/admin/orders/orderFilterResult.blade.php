@if($orders->count() > 0)
<div class="table-responsive">
    <table class="table" id="exportexample">
        <thead>
            <tr>
                <th>{{trans('home.order_number')}}</th>
                <th>{{trans('home.order_date')}}</th>
                <th>{{trans('home.order_user')}}</th>
                <th>{{trans('home.order_address')}}</th>
                <th>{{trans('home.order_phone_numbers')}}</th>
                <th>{{trans('home.order_status')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $key=>$order)
                <tr>
                    <td><a href="{{ route('orders.edit', $order->id) }}">{{$order->id}}</a></td>
                    <td>{{date('Y-m-d', strtotime($order->created_at ))}}</td>
                    <td><a href="{{ route('orders.edit', $order->id) }}">{{$order->user->name()}}</a></td>
                    <td><a href="{{ route('orders.edit', $order->id) }}">{{$order->address->address}}</a></td>
                    <td><a href="{{ route('orders.edit', $order->id) }}">{{$order->address->phone1}} @if($order->address->phone1) - {{$order->address->phone1}} @endif</a></td>                                                    
                    <td>
                        @if($order->status == 'pending')
                            <span class="badge badge-primary">{{trans('home.pending')}}</span>
                        @elseif($order->status == 'accept')
                            <span class="badge badge-secondary">{{trans('home.accept')}}</span>
                        @elseif($order->status == 'process')
                            <span class="badge badge-info">{{trans('home.process')}}</span>
                        @elseif($order->status == 'shipping')
                            <span class="badge badge-default">{{trans('home.shipping')}}</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge badge-success">{{trans('home.delivered')}}</span>
                        @elseif($order->status == 'canceled')
                            <span class="badge badge-danger">{{trans('home.canceled')}}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <div class="text-center">
        <p>{{trans('home.no_orders_found')}}</p>
    </div>
@endif