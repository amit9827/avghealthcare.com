@extends('adminlte::page')


@section('title', 'Dashboard')

@section('content_header')
    <h1>ratings</h1>
@stop

@section('content')



@include('admin.errors')


<form action="{{ route('admin.rating_store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <a href="{{ route('admin.rating_new') }}" class="btn btn-primary">+ Add rating</a>
</form>

<table class="table table-striped table-full-width mt-5" >
<tbody>
    <tr>
        <td><input type="checkbox" name="select_all"></td>
        <td>Date</td>
        <td>Name</td>
        <td>Product</td>

        <td>Message</td>
        <td>Star</td>
        <td>Verified</td>
        <td>Approved</td>


     </tr>


    @foreach ($data['ratings'] as $rating)



    <tr>
        <td><input type="checkbox" name="select_all"></td>
        <td>{{ $rating->review_date}}</td>



        <td><a href="{{ route('admin.rating_get', $rating->id  ) }}">{{ $rating->name}}</a>
           </td>
        <td>{{ $rating->product->title ?? '--'}} (id:{{ $rating->product_id }})</td>
        <td>{{ $rating->message}}</td>
        <td>{{ $rating->star_rating}}</td>
        <td>{{ $rating->verified_buyer ? "Y" : 'N'}}</td>
        <td>{{ $rating->approved ? "Y" : "N"}}  <a href="{{ route('admin.rating_delete', $rating->id  ) }}" class="text-danger" onclick="return confirm('Do you really want to delete?')" ><i class=" fas fa-fw fa-trash "></i></a></td>


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
