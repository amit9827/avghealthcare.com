@extends('adminlte::page')

@section('title', isset($data['ingredient']) ? 'Edit ingredient' : 'Add ingredient')

@section('content_header')
    <h1>{{ isset($data['ingredient']) ? 'Edit ingredient' : 'Add ingredient' }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.ingredient_store') }}" method="POST" enctype="multipart/form-data">
            @csrf


            <!-- Name -->
            <div class="form-group">
                <label for="name">ingredient Name</label>
                <input type="text"
                       name="name"
                       id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $data['ingredient']->name ?? '') }}"
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
                       value="{{ old('slug', $data['ingredient']->slug ?? '') }}">
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
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $data['ingredient']->description ?? '') }}</textarea>
                @error('description')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Parent ingredient -->
            <div class="form-group">
                <label for="parent_id">Parent ingredient</label>
                <select name="parent_id"
                        id="parent_id"
                        class="form-control @error('parent_id') is-invalid @enderror">
                    <option value="">-- None --</option>
                    @foreach($data['all_ingredients'] as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('parent_id', $data['ingredient']->parent_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image -->
            <div class="form-group">
                <label for="image_path">ingredient Image</label>
                <input type="file"
                       name="image_path"
                       id="image_path"
                       class="form-control-file @error('image_path') is-invalid @enderror">
                @if(isset($data['ingredient']->image_path))
                    <div class="mt-2">
                        <a href="{{ route('image.show', $data['ingredient']->image_path) }}"><img src="{{ route('image.show', $data['ingredient']->image_path) }}" alt="ingredient Image" height="80"></a>


                    </div>
                @endif
                @error('image_path')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Hidden ID -->
            <input type="hidden" name="ingredient_id" value="{{ $data['ingredient']->id ?? '' }}">

            <!-- Buttons -->
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> {{ isset($data['ingredient']) ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.ingredient') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>
@stop
