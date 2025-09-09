@extends('adminlte::page')


@section('title', 'Dashboard')


@section('content_header')
    <h1>Add order</h1>
@stop

@section('content')

@include('admin.errors')






<table class="table table-responsive">
<tr>
    <td>product_id</td>
    <td>price</td>
    <td>quantity</td>
    <td>amount</td>
</tr>

@foreach($data['order']->shopping_cart_items as $cart_item)

<tr>
    <td>{{ $cart_item->product_id }}</td>
    <td>{{ $cart_item->price }}</td>
    <td>{{ $cart_item->quantity }}</td>
    <td>{{ $cart_item->amount }}</td>
</tr>

@endforeach

</table>


@stop




