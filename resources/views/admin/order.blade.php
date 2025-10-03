@extends('adminlte::page')

@section('title', 'Order Details')

@section('content_header')
    <h1>Order #{{ $data['order']->id }}</h1>
@stop

@section('content')

@include('admin.errors')

<p>
    <a href="{{ route('order_status', ['txn_id' => $data['order']->txn_id]) }}" class="btn btn-primary" target="_blank">
        View Order (Txn: {{ $data['order']->txn_id }})
    </a>
</p>

{{-- Customer Details --}}
<div class="card mb-4">
    <div class="card-header">
        <strong>Customer Details</strong>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $data['order']->customer->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>
                    {{ $data['order']->customer->address ?? '' }},
                    {{ $data['order']->customer->town ?? '' }},
                    {{ $data['order']->customer->state ?? '' }} - {{ $data['order']->customer->pin_code ?? '' }}
                </td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $data['order']->customer->phone ?? '' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $data['order']->customer->email ?? '' }}</td>
            </tr>
            <tr>
                <th>Customer Since</th>
                <td>{{ $data['order']->customer->created_at ?? '' }}</td>
            </tr>
        </table>
    </div>
</div>

{{-- Order Items --}}
<div class="card mb-4">
    <div class="card-header">
        <strong>Order Items</strong>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['order']->shopping_cart_items as $cart_item)
                <tr>
                    <td>
                        {{ $cart_item->product->title }}
                        (<a href="{{ route('admin.product_get', ['id' => $cart_item->product_id]) }}">ID: {{ $cart_item->product_id }}</a>)
                    </td>
                    <td>{{ $cart_item->price }}</td>
                    <td>{{ $cart_item->quantity }}</td>
                    <td>{{ $cart_item->amount }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Order Summary & Update Form --}}
<div class="card">
    <div class="card-header">
        <strong>Order Summary</strong>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.order_update', ['id' => $data['order']->id ]) }}" method="POST">
            @csrf

            <p>Shipping Amount: <strong>{{ $data['order']->shipping_fee }}</strong></p>
            <p>Payment Fee: <strong>{{ $data['order']->payment_fee }}</strong></p>
            <h4>Total Amount: {{ $data['order']->total_amount }}</h4>

            <div class="form-group">
                <label>Order Status</label>
                <select name="order_status" class="form-control">
                    <option value="{{ $data['order']->order_status }}">{{ $data['order']->order_status }}</option>
                    <option value="">--------</option>
                    <option value="PENDING">PENDING</option>
                    <option value="COMPLETED">COMPLETED</option>
                    <option value="CANCELED">CANCELED</option>
                </select>
            </div>

            <p>Payment Mode: {{ $data['order']->payment_mode }}</p>
            <p>Txn ID: {{ $data['order']->txn_id }}</p>

            <div class="form-group">
                <label>Dispatch Status</label>
                <select name="dispatch_status" class="form-control">
                    <option value="{{ $data['order']->dispatch_status }}">{{ $data['order']->dispatch_status }}</option>
                    <option value="">--------</option>
                    <option value="PENDING">PENDING</option>
                    <option value="COMPLETED">COMPLETED</option>
                    <option value="CANCELED">CANCELED</option>
                </select>
            </div>

            <p>Created at: {{ $data['order']->created_at }}</p>
            <p>Updated at: {{ $data['order']->updated_at }}</p>

            <button type="submit" class="btn btn-success mt-3">Update Order</button>
        </form>
    </div>
</div>

@stop
