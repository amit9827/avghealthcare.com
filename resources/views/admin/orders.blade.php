@extends('adminlte::page')

@section('title', 'Orders')

@section('content_header')
    <h1>Orders</h1>
@stop

@section('content')

@include('admin.errors')

<a class="btn btn-primary mb-3" href="{{ route('admin.page') }}">Add Order</a>

{{-- Tabs navigation --}}
<ul class="nav nav-tabs" id="orderTabs" role="tablist">

    <li class="nav-item">
        <a class="nav-link active" id="completed-tab" data-toggle="tab" href="#completed" role="tab">Completed</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab">Pending</a>
    </li>

    <li class="nav-item">
        <a class="nav-link " id="all-tab" data-toggle="tab" href="#all" role="tab">All</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="processing-tab" data-toggle="tab" href="#processing" role="tab">Failed</a>
    </li>

</ul>

{{-- Tabs content --}}
<div class="tab-content mt-3" id="orderTabsContent">

      {{-- Completed --}}
      <div class="tab-pane fade  show active" id="completed" role="tabpanel">
        @include('admin.orders_table', ['orders' => $data['orders']->where('order_status', 'COMPLETED')])
    </div>

    <div class="tab-pane fade" id="pending" role="tabpanel">
        @include('admin.orders_table', ['orders' => $data['orders']->where('order_status', 'PENDING')])
    </div>


    {{-- All Orders --}}
    <div class="tab-pane fade" id="all" role="tabpanel">
        @include('admin.orders_table', ['orders' => $data['orders']])
    </div>


    {{-- Processing --}}
    <div class="tab-pane fade" id="processing" role="tabpanel">
        @include('admin.orders_table', ['orders' => $data['orders']->where('order_status', 'FAILED')])
    </div>



</div>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    <script>
        console.log('Orders page loaded');
    </script>
@stop
