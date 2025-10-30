@extends('adminlte::page')


@section('title', 'Ratings Add/Update')

@section('content_header')
    <h1>Ratings Add/Update</h1>
@stop

@section('content')


<div class="container py-4">
    <h3 class="mb-4">
        {{ isset($data['rating']) ? 'Edit Review' : 'Add New Review' }}

    </h3>

    <p><a href="{{ route('admin.ratings') }}"><= Back to Product List</a> |
        @if(isset($data['rating']->product ))
        <a href="{{ url('/') }}/product/{{ $data['rating']->product->slug }}" target="_blank">View Product</a>
    @endif
</p>
@include('admin.errors')




    <form
        action="{{ route('admin.rating_store') }}"
        method="POST"
    >
        @csrf

        {{-- Product --}}
        <div class="mb-3">
            <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
            <select
                name="product_id"
                id="product_id"
                class="form-select p-1"
                required
            >
                <option value="">-- Select Product --</option>
                @foreach($data['products'] as $product)
                    <option value="{{ $product->id }}"
                        {{ old('product_id', $data['rating']->product_id ?? '') == $product->id ? 'selected' : '' }}>
                        {{ $product->title }}
                    </option>
                @endforeach
            </select>
            @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Reviewer Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Reviewer Name</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $data['rating']->name ?? '') }}"
            >
         </div>

        {{-- Message --}}
        <div class="mb-3">
            <label for="message" class="form-label">Review Message</label>
            <textarea
                name="message"
                id="message"
                rows="4"
                class="form-control @error('message') is-invalid @enderror"
            >{{ old('message', $data['rating']->message ?? '') }}</textarea>
         </div>

        {{-- Star Rating --}}
        <div class="mb-3">
            <label for="star_rating" class="form-label">Star Rating (1–5)</label>
            <input
                type="number"
                name="star_rating"
                id="star_rating"
                min="1"
                max="5"
                class="form-control @error('star_rating') is-invalid @enderror"
                value="{{ old('star_rating', $data['rating']->star_rating ?? '') }}"
            >
         </div>

        {{-- Review Date --}}
        <div class="mb-3">
            <label for="review_date" class="form-label">Review Date</label>
            <input
                type="date"
                name="review_date"
                id="review_date"
                class="form-control @error('review_date') is-invalid @enderror"
                value="{{ old('review_date', $data['rating']->review_date ?? now()->format('Y-m-d')) }}"
            >
         </div>

        {{-- Verified Buyer --}}
        <div class="form-check mb-3">
            <input
                class="form-check-input"
                type="checkbox"
                name="verified_buyer"
                id="verified_buyer"
                value="1"
                {{ old('verified_buyer', $data['rating']->verified_buyer ?? true) ? 'checked' : '' }}
            >
            <label class="form-check-label" for="verified_buyer">Verified Buyer</label>
        </div>

        {{-- Approved --}}
        <div class="form-check mb-4">
            <input
                class="form-check-input"
                type="checkbox"
                name="approved"
                id="approved"
                value="1"
                {{ old('approved', $data['rating']->approved ?? true) ? 'checked' : '' }}
            >
            <label class="form-check-label" for="approved">Approved</label>.
            <input type="hidden" name="rating_id" value="{{ $data['rating']->id ?? '' }}" >
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                {{ isset($data['rating']) ? 'Update Review' : 'Submit Review' }}
            </button>
        </div>
    </form>
</div>
@endsection
