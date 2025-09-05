@extends('adminlte::page')


@section('title', 'Dashboard')

@section('content_header')
    <h1>Orders</h1>
@stop

@section('content')



@include('admin.errors')



<form action="{{ route('admin.page_store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <a class="btn btn-primary" href="{{ route('admin.page') }}">Add Order</a>
</form>

<table class="table table-striped table-full-width mt-5" >
<tbody>
    <tr>
        <td><input type="checkbox" name="select_all"></td>
        <td>Order</td>
        <td>Date</td>
        <td>Status</td>
        <td>Total</td>
        <td></td>
    </tr>


    @foreach ($data['orders'] as $order)




    <tr>
        <td><input type="checkbox" name="select_all"></td>


        <td><a href="{{ route('admin.order_get', $order->id  ) }}">#{{ $order->id}} {{ ucwords($order->customer->name) ?? ''}}</a></td>
        <td>{{ $order->created_at}}</td>
        <td>{{ $order->order_status}}</td>
        <td>{{ $order->total_amount}}</td>



        <td><a href="{{ route('admin.order_delete', $order->id) }}" onclick="return confirm('Are you sure ?')"><i class="fas fa-trash"></i></a></td>


    </tr>





    @endforeach
</tbody>

</table>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    <script>
        console.log('Admin Dashboard Loaded');
    </script>
@stop
