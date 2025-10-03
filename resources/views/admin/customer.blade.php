@extends('adminlte::page')

@section('title', 'Customer Details')

@section('content_header')
    <h1>Customer Details</h1>
@stop

@section('content')

@include('admin.errors')

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <strong>{{ $data['customer']->name ?? 'Unknown Customer' }}</strong>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $data['customer']->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $data['customer']->name }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>
                    {{ $data['customer']->address ?? '' }},
                    {{ $data['customer']->town ?? '' }},
                    {{ $data['customer']->state ?? '' }} - {{ $data['customer']->pin_code ?? '' }}
                </td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $data['customer']->phone }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $data['customer']->email }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $data['customer']->created_at }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $data['customer']->updated_at }}</td>
            </tr>
        </table>

        <p class="mt-2">

        <a class="btn btn-secondary" href="{{ route('admin.customers') }}">Back to Customers</a>
        </p>

    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    <script>
        console.log('Customer details page loaded');
    </script>
@stop
