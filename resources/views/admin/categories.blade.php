@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Categories</h1>
@stop

@section('content')


@include('admin.errors')
<div class="card">
    <div class="card-header">

        <div class="ms-0 float-left">
        <h3 class="card-title ms-0">Category List</h3>
        </div>
        <div class=" me-0 float-right">
        <a href="{{ route('admin.category') }}" class="btn btn-primary ">
            <i class="fas fa-plus"></i> Add New Category
        </a>
    </div>
    </div>


    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Title</th>
                    <th>Desciption</th>
                    <th>Slug</th>
                    <th>Priority</th>
                 </tr>
            </thead>
            <tbody>
                @forelse($data['categories'] as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>  <a href="{{ route('admin.category_get', [$category->id]) }}"
                           >{{ $category->name }} </a>
                           <a href="{{ route('admin.category_delete', $category->id  ) }}" class="text-danger" onclick="return confirm('Do you really want to delete?')" ><i class=" fas fa-fw fa-trash "></i></a></td>

                        </td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->priority }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-center">
        {{ $data['categories']->links('pagination::bootstrap-4') }}
    </div>
</div>
@stop
