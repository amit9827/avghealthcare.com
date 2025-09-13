@extends('adminlte::page')

@section('title', isset($data['category']) ? 'Edit Category' : 'Add Category')

@section('content_header')
    <h1>{{ isset($data['category']) ? 'Edit Category' : 'Add Category' }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.category_store') }}" method="POST" enctype="multipart/form-data">
            @csrf


            <!-- Name -->
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text"
                       name="name"
                       id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $data['category']->name ?? '') }}"
                       required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Slug -->
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text"
                       name="slug"
                       id="slug"
                       class="form-control @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $data['category']->slug ?? '') }}">
                @error('slug')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description"
                          id="description"
                          rows="3"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $data['category']->description ?? '') }}</textarea>
                @error('description')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Parent Category -->
            <div class="form-group">
                <label for="parent_id">Parent Category</label>
                <select name="parent_id"
                        id="parent_id"
                        class="form-control @error('parent_id') is-invalid @enderror">
                    <option value="">-- None --</option>
                    @foreach($data['all_categories'] as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('parent_id', $data['category']->parent_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>


                   <!-- Boolean Checkboxes -->
                   <div class="row">
                    <div class="col-md-12">
                    <label for="sale_price">Status</label>
                    </div>

                    <div class="col-md-4">
                <div class="form-group form-check">
                    <input type="checkbox" name="visibility" class="form-check-input" id="visibility" value="1"
                    {{ isset($data['category']->visibility) &&  $data['category']->visibility==1 ? 'checked': '' }} >
                    <label class="form-check-label" for="visibility">Visible</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-check">
                    <input type="checkbox" name="featured" class="form-check-input" id="featured" value="1"
                     {{ isset($data['category']->featured) &&  $data['category']->featured==1 ? 'checked': '' }} >
                    <label class="form-check-label" for="featured">Featured</label>
                </div>
            </div>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label for="image_path">Category Image</label>
                <input type="file"
                       name="image_path"
                       id="image_path"
                       class="form-control-file @error('image_path') is-invalid @enderror">
                @if(isset($data['category']->image_path))
                    <div class="mt-2">
                        <a href="{{ route('image.show', $data['category']->image_path) }}"><img src="{{ route('image.show', $data['category']->image_path) }}" alt="Category Image" height="80"></a>


                    </div>
                @endif
                @error('image_path')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Hidden ID -->
            <input type="hidden" name="category_id" value="{{ $data['category']->id ?? '' }}">

            <!-- Buttons -->
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> {{ isset($data['category']) ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.categories') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>
@stop
