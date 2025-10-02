@extends('adminlte::page')


@section('title', 'Dashboard')


@section('content_header')
    <h1>Order</h1>
@stop

@section('content')

@include('admin.errors')



<p><a href="{{ route('order_status', ['txn_id' => $data['order']->txn_id]) }}" class="button" target="_blank">View Order -  {{ $data['order']->id  }}</a></p>



<table class="table table-responsive">
<tr>
    <td>Product</td>
    <td>Price</td>
    <td>Quantity</td>
    <td>Amount</td>
</tr>

@foreach($data['order']->shopping_cart_items as $cart_item)

<tr>
    <td>{{ $cart_item->product->title }} ( id: <a href="{{ route('admin.product_get', ['id' => $cart_item->product_id] ) }}">{{ $cart_item->product_id }}</a> ) </td>
    <td>{{ $cart_item->price }}</td>
    <td>{{ $cart_item->quantity }}</td>
    <td>{{ $cart_item->amount }}</td>
</tr>

@endforeach

</table>

<form action="{{ route('admin.order_update', ['id' => $data['order']->id ]) }}" method="POST">
@csrf

Shipping Amount : {{ $data['order']->shipping_fee }} </br>
Payment Fee : {{ $data['order']->payment_fee }} </br>
<h2>
Total Amount : {{ $data['order']->total_amount }} </h2></br>
Order Status :
<select name="order_status">

    <option value="{{ $data['order']->order_status }} ">{{ $data['order']->order_status }} </option>
    <option value="{{ $data['order']->order_status }} ">--------</option>
    <option value="PENDING">PENDING</option>
    <option value="COMPLETED">COMPLETED</option>
    <option value="CANCELED">CANCELED</option>

</select>

</br>
Payment Mode : {{ $data['order']->payment_mode }} </br>
Txn ID : {{ $data['order']->txn_id }}</br>

<hr>
Dispatch Status :
<select name="dispatch_status">

    <option value="{{ $data['order']->dispatch_status }} ">{{ $data['order']->dispatch_status }} </option>
    <option value="{{ $data['order']->dispatch_status }} ">--------</option>
    <option value="PENDING">PENDING</option>
    <option value="COMPLETED">COMPLETED</option>
    <option value="CANCELED">CANCELED</option>

</select>
</br>

Created at : {{ $data['order']->created_at }}</br>
Updated at : {{ $data['order']->updated_at }}</br>


<input type="submit" name="update" value="update" class="form-control col-md-3 mt-3">
</form>
@stop


