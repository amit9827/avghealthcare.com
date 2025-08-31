@extends('adminlte::page')


@section('title', 'Dashboard')

@section('content_header')
    <h1>pages</h1>
@stop

@section('content')



@include('admin.errors')



<form action="{{ route('admin.page_store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <a class="btn btn-primary" href="{{ route('admin.page') }}">Add page</a>
</form>

<table class="table table-striped table-full-width mt-5" >
<tbody>
    <tr>
        <td><input type="checkbox" name="select_all"></td>
        <td>Name</td>
        <td>Author</td>
        <td>Date</td>
        <td>Action</td>
    </tr>


    @foreach ($data['pages'] as $page)




    <tr>
        <td><input type="checkbox" name="select_all"></td>


        <td><a href="{{ route('admin.page_get', $page->id  ) }}">{{ $page->title}}</a></td>
        <td>{{ $page->created_by ?? ''}}</td>

        <td>{{ $page->created_at}}</td>
        <td><a href="{{ route('admin.page_delete', $page->id) }}" onclick="return confirm('Are you sure ?')"><i class="fas fa-trash"></i></a></td>


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
