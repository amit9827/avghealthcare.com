@extends('adminlte::page')


@section('title', 'Dashboard')

@section('content_header')
    <h1>customers</h1>
@stop

@section('content')



@include('admin.errors')





<table class="table table-striped table-full-width mt-5" >
<tbody>
    <tr>
        <td><input type="checkbox" name="select_all"></td>
        <td>customer</td>
        <td>Date Registered</td>
        <td>Email</td>
        <td>Orders</td>
        <td>Total Spent</td>
        <td>Town</td>
        <td>State</td>
        <td>Phone</td>
        <td></td>
    </tr>


    @foreach ($data['customers'] as $customer)




    <tr>
        <td><input type="checkbox" name="select_all"></td>


        <td><a href="{{ route('admin.customer_get', $customer->id  ) }}">#{{ $customer->id}} {{ ucwords($customer->name) ?? ''}}</a></td>
        <td>{{ $customer->created_at->format("d-m-Y")}}</td>
        <td>{{ $customer->email}}</td>
        <td>{{ $customer->completed_orders_count() }}</td>
        <td>{{ $customer->completed_orders_amount() }}</td>
        <td>{{ $customer->town}}</td>
        <td>{{ $customer->state}}</td>
        <td>{{ $customer->phone}}</td>



        <td><a href="{{ route('admin.customer_delete', $customer->id) }}" onclick="return confirm('Are you sure ?')"><i class="fas fa-trash"></i></a></td>


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
