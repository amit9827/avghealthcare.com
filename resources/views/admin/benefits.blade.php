@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>benefits</h1>
@stop

@section('content')

@include('admin.errors')
<div class="card">
    <div class="card-header">

        <div class="ms-0 float-left">
        <h3 class="card-title ms-0">benefits List</h3>
        </div>
        <div class=" me-0 float-right">
        <a href="{{ route('admin.benefit') }}" class="btn btn-primary ">
            <i class="fas fa-plus"></i> Add New benefit
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
                 </tr>
            </thead>
            <tbody>
                @forelse($data['benefits'] as $benefit)
                    <tr>
                        <td>{{ $benefit->id }}</td>
                        <td>  <a href="{{ route('admin.benefit_get', [$benefit->id]) }}"
                           >{{ $benefit->name }} </a>
                           <a href="{{ route('admin.benefit_delete', $benefit->id  ) }}" class="text-danger" onclick="return confirm('Do you really want to delete?')" ><i class=" fas fa-fw fa-trash "></i></a></td>
                         </td>
                        <td>{{ $benefit->description }}</td>
                        <td>{{ $benefit->slug }}</td>

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
        {{ $data['benefits']->links('pagination::bootstrap-4') }}
    </div>
</div>
@stop
