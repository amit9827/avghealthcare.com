@extends('adminlte::page')


@section('title', 'Dashboard')


@section('content_header')
    <h1>Add Page</h1>
@stop

@section('content')




@include('admin.errors')

<form action="{{ route('admin.page_store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add Page</h3>
        </div>
        <div class="card-body">

            <!-- Title -->
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ $data['page']->title ?? '' }}" required>
            </div>




            <!-- featured_image -->
            <div class="form-group">
                <label for="featured_image">Featured image</label>
                @if(isset($data['page']->featured_image))
                 <div class="mt-2">
                    @if($data['page']->featured_image)
                    <a href="{{ route('image.show', $data['page']->featured_image) }}">
                        <img src="{{ route('image.show', $data['page']->featured_image) }}" alt="Featured Image" height="80">
                    </a>
                    <input type="checkbox" name="featured_image_delete" value="1">

                    @endif
                </div>
                @endif

                <input type="file" name="featured_image" class="form-control" id="featured_image"  >
            </div>











            <!-- Description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control textarea" id="description" rows="3">{{ $data['page']->description ?? '' }}</textarea>
            </div>

            <!-- Long Description -->
            <div class="form-group">
                <label for="long_description">Long Description</label>
                <textarea name="long_description" class="form-control textarea" id="summernote" rows="3">{{ $data['page']->long_description ?? '' }}</textarea>
            </div>




            <div class="form-group">
                <label for="ingredients_tags">Tags</label>
                <textarea name="page_tags" class="form-control" id="page_tags" rows="3">{{ $data['page']->page_tags ?? '' }}</textarea>
            </div>





            </div>




            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">SEO Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter SEO title"  value="{{ $data['page']->meta_title ?? '' }}" >
                    </div>
                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Enter SEO description"   >{{ $data['page']->meta_description ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Enter keywords, separated by commas"  value="{{ $data['page']->meta_keywords ?? '' }}" >
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug / URL</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="page-slug"  value="{{ $data['page']->slug ?? '' }}" >
                    </div>
                </div>
            </div>


           <input type="hidden"  name="page_id" value="{{ $data['page']->id ?? '' }}" >


        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>



@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    <script>
        console.log('Admin page Loaded');
    </script>




<!-- CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>



<script>
  $(function () {
    $('#summernote').summernote({
      height: 200
    });
  });
</script>



@stop
