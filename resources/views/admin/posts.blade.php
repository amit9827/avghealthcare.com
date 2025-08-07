@extends('adminlte::page')


@section('title', 'Dashboard')

@section('content_header')
    <h1>Posts</h1>
@stop

@section('content')


    @if (session('success'))
    <x-adminlte-alert theme="success" title="Success!" dismissable>
        {{ session('success') }}
    </x-adminlte-alert>
@endif

<form action="{{ route('admin.posts') }}" method="POST">
    @csrf

    <x-adminlte-input name="name" label="Full Name" placeholder="Enter your full name" value="{{ old('name') }}" error-key="name" />

    <x-adminlte-input name="email" label="Email" type="email" placeholder="Enter email" value="{{ old('email') }}" error-key="email" />

    <x-adminlte-button class="btn btn-primary" type="submit" label="Submit" />
</form>


@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    <script>
        console.log('Admin Dashboard Loaded');
    </script>
@stop
