@extends('adminlte::page')


@section('title', 'Dashboard')

@section('content_header')
    <h1>Products</h1>
@stop

@section('content')



@include('admin.errors')


<form action="{{ route('admin.product_store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <a href="{{ route('admin.product') }}" class="btn btn-primary">+ Add Product</a>
</form>

<table class="table table-striped table-full-width mt-5" >
<tbody>
    <tr>
        <td><input type="checkbox" name="select_all"></td>
        <td>Name</td>
        <td>SKU</td>
        <td>Stock</td>
        <td>Price</td>
        <td>Qty</td>
        <td>Priority</td>
        <td>*</td>
        <td>Date</td>
    </tr>


    @foreach ($data['products'] as $product)




    <tr>
        <td><input type="checkbox" name="select_all"></td>


        <td><a href="{{ route('admin.product_get', $product->id  ) }}">{{ $product->title}}</a>
            <a href="{{ route('admin.product_delete', $product->id  ) }}" class="text-danger" onclick="return confirm('Do you really want to delete?')" ><i class=" fas fa-fw fa-trash "></i></a></td>
        <td>{{ $product->sku}}</td>
        <td>{{ $product->stock_quantity}}</td>
        <td>{!! $product->onsale ? "<del>".$product->regular_price."</del> ". $product->sale_price :  $product->regular_price !!}</td>
        <td>{{ $product->stock_quantity}}</td>
        <td>{{ $product->priority}}</td>

        <td>{{ $product->featured ? "*" : ''}}</td>

        <td>{{ $product->created_at}}</td>


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
