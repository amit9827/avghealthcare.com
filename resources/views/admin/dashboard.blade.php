@extends('adminlte::page')


@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to your Admin Panel Dashboard!</p>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    <script>
        console.log('Admin Dashboard Loaded');
    </script>
@stop
