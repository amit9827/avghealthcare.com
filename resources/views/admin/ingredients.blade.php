@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Ingredients</h1>
@stop

@section('content')

@include('admin.errors')
<div class="card">
    <div class="card-header">

        <div class="ms-0 float-left">
        <h3 class="card-title ms-0">Ingredients List</h3>
        </div>
        <div class=" me-0 float-right">
        <a href="{{ route('admin.ingredient') }}" class="btn btn-primary ">
            <i class="fas fa-plus"></i> Add New Ingredient
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
                @forelse($data['ingredients'] as $ingredient)
                    <tr>
                        <td>{{ $ingredient->id }}</td>
                        <td>  <a href="{{ route('admin.ingredient_get', [$ingredient->id]) }}"
                           >{{ $ingredient->name }} </a>
                           <a href="{{ route('admin.ingredient_delete', $ingredient->id  ) }}" class="text-danger" onclick="return confirm('Do you really want to delete?')" ><i class=" fas fa-fw fa-trash "></i></a></td>
                         </td>
                        <td>{{ $ingredient->description }}</td>
                        <td>{{ $ingredient->slug }}</td>

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
        {{ $data['ingredients']->links('pagination::bootstrap-4') }}
    </div>
</div>
@stop
