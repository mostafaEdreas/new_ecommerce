
<br>
<div id="DivIdToPrint">

    <div class="text-center">
        <h2>{{trans('home.accounting_report')}}</h2>
        <h4>{{trans('home.from')}} : {{$from}}</h4>
        <h4>{{trans('home.to')}} : {{$to}}</h4>
    </div>
    <table  class="table table-striped table-bordered table-hover">
        <thead>
        <th>#</th>
        <th>{{trans('home.date')}}</th>
        <th>{{trans('home.invoice_number')}}</th>
        <th>{{trans('home.payment_method')}}</th>
        <th>{{trans('home.user')}}</th>
        <th>{{trans('home.grand_total')}}</th>
        <th>{{trans('home.status')}}</th>
        <tbody>
        @foreach ($invoices as $key=>$invoice)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$invoice->created_at}}</td>
                <td>{{$invoice->invoice_number}}</td>
                <td>{{$invoice->payment->name_en}}</td>
                <td>{{$invoice->user->name()}}</td>
                <td>{{$invoice->grand_total}}</td>
                <td>{{$invoice->status}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
