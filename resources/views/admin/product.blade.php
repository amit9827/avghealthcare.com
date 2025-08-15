@extends('adminlte::page')


@section('title', 'Dashboard')

@section('content_header')
    <h1>Add Product</h1>
@stop

@section('content')




@include('admin.errors')

<form action="{{ route('admin.product_store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add Product</h3>
        </div>
        <div class="card-body">

            <!-- Title -->
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ $data['product']->title ?? '' }}" required>
            </div>




            <!-- featured_image -->
            <div class="form-group">
                <label for="featured_image">Featured image</label>
                @if(isset($data['product']->featured_image))
                 <div class="mt-2">
                    <a href="{{ route('image.show', $data['product']->featured_image) }}"><img src="{{ route('image.show', $data['product']->featured_image) }}" alt="Featured Image" height="80"></a>
                </div>
                @endif




                <input type="file" name="featured_image" class="form-control" id="featured_image"  >
            </div>

            <!-- featured_image -->
            <div class="form-group">
                <label for="benefit_image">Benefit image</label>
                @if(isset($data['product']->benefit_image))

                <div class="mt-2">
                    <a href="{{ route('image.show', $data['product']->benefit_image) }}"><img src="{{ route('image.show', $data['product']->benefit_image) }}" alt="Benefit Image" height="80"></a>
                </div>
                @endif

                <input type="file" name="benefit_image" class="form-control" id="benefit_image"  >
            </div>

            <!-- featured_image -->
            <div class="form-group">
                <label for="banner_image">Banner image</label>
                @if(isset($data['product']->banner_image))

                <div class="mt-2">
                    <a href="{{ route('image.show', $data['product']->banner_image) }}"><img src="{{ route('image.show', $data['product']->banner_image) }}" alt="Banner Image" height="80"></a>
                </div>
                @endif

                <input type="file" name="banner_image" class="form-control" id="banner_image"  >
            </div>






            <!-- Description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description" rows="3">{{ $data['product']->description ?? '' }}</textarea>
            </div>

            <!-- Long Description -->
            <div class="form-group">
                <label for="long_description">Long Description</label>
                <textarea name="long_description" class="form-control" id="long_description" rows="3">{{ $data['product']->long_description ?? '' }}</textarea>
            </div>


            <div class="form-group">
                <label for="ingredients_tags">Ingredient Tags</label>
                <textarea name="ingredients_tags" class="form-control" id="ingredients_tags" rows="3">{{ $data['product']->ingredients_tags ?? '' }}</textarea>
            </div>

            <!-- Long Description -->
            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea name="ingredients" class="form-control" id="ingredients" rows="3">{{ $data['product']->ingredients ?? '' }}</textarea>
            </div>

                   <!-- Long Description -->



            <div class="form-group">
                <label for="ingredients_tags">Benefit Tags</label>
                <textarea name="benefits_tags" class="form-control" id="benefits_tags" rows="3">{{ $data['product']->benefits_tags ?? '' }}</textarea>
            </div>


            <div class="form-group">
                <label for="ingredients">Benefits</label>
                <textarea name="benefits" class="form-control" id="benefits" rows="3">{{ $data['product']->benefits ?? '' }}</textarea>
            </div>






            <!-- SKU -->
            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" name="sku" class="form-control" id="sku" value="{{ $data['product']->sku ?? '' }}" >
            </div>

            <!-- Price Fields -->
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="min_price">Min Price</label>
                    <input type="number" step="0.01" name="min_price" class="form-control" id="min_price"  value="{{ $data['product']->min_price ?? '' }}" >
                </div>
                <div class="form-group col-md-3">
                    <label for="max_price">Max Price</label>
                    <input type="number" step="0.01" name="max_price" class="form-control" id="max_price"  value="{{ $data['product']->max_price ?? '' }}" >
                </div>
                <div class="form-group col-md-3">
                    <label for="regular_price">Regular Price</label>
                    <input type="number" step="0.01" name="regular_price" class="form-control" id="regular_price"  value="{{ $data['product']->regular_price ?? '' }}" >
                </div>
                <div class="form-group col-md-3">
                    <label for="sale_price">Sale Price</label>
                    <input type="number" step="0.01" name="sale_price" class="form-control" id="sale_price"  value="{{ $data['product']->sale_price ?? '' }}" >
                </div>
            </div>

            <!-- Sale Dates -->
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="sale_start_date">Sale Start Date</label>
                    <input type="date" name="sale_start_date" class="form-control" id="sale_start_date"  value="{{ $data['product']->sale_start_date ?? '' }}" >
                </div>
                <div class="form-group col-md-6">
                    <label for="sale_end_date">Sale End Date</label>
                    <input type="date" name="sale_end_date" class="form-control" id="sale_end_date"  value="{{ $data['product']->sale_end_date ?? '' }}" >
                </div>
            </div>

            <!-- Boolean Checkboxes -->
            <div class="row">
                <div class="col-md-12">
                <label for="sale_price">Status</label>
                </div>

                <div class="col-md-4">
                    <div class="form-group col-md-4 ps-3 form-check">
                        <input type="checkbox" name="onsale" class="form-check-input" id="onsale" value="1"
                         {{ isset($data['product']->onsale) &&  $data['product']->onsale==1 ? 'checked': '' }} >
                        <label class="form-check-label" for="onsale">On Sale</label>
                    </div>
                </div>
                <div class="col-md-4">
            <div class="form-group form-check">
                <input type="checkbox" name="visibility" class="form-check-input" id="visibility" value="1"
                {{ isset($data['product']->visibility) &&  $data['product']->visibility==1 ? 'checked': '' }} >
                <label class="form-check-label" for="visibility">Visible</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group form-check">
                <input type="checkbox" name="featured" class="form-check-input" id="featured" value="1"
                 {{ isset($data['product']->featured) &&  $data['product']->featured==1 ? 'checked': '' }} >
                <label class="form-check-label" for="featured">Featured</label>
            </div>
        </div>
        </div>

            <!-- Product Type & Slug -->
            <div class="form-group">
                <label for="product_type">Product Type</label>
                <select class="form-control" id="product_type" name="product_type">
                    <option value="simple"  {{ isset($data['product']->product_type) &&  $data['product']->product_type=="simple" ? 'selected': '' }} >Simple</option>
                    <option value="variable"  {{ isset($data['product']->product_type) &&  $data['product']->product_type=="variable" ? 'selected': '' }} >Variable</option>
                    <option value="grouped"  {{ isset($data['product']->product_type) &&  $data['product']->product_type=="grouped" ? 'selected': '' }} >Grouped</option>
                    <option value="external"  {{ isset($data['product']->product_type) &&  $data['product']->product_type=="external" ? 'selected': '' }} >External/Affiliate</option>
                </select>
            </div>

            <!-- Stock & Ratings -->
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="stock_quantity">Stock Quantity</label>
                    <input type="number" name="stock_quantity" class="form-control" id="stock_quantity"  value="{{ $data['product']->stock_quantity ?? '' }}" >
                </div>
                <div class="form-group col-md-3">
                    <label for="stock_status">Stock Status</label>
                    <select name="stock_status" class="form-control" id="stock_status" >
                        <option value="instock"  {{ isset($data['product']->stock_status) &&  $data['product']->stock_status=="instock" ? 'selected': '' }} >In Stock</option>
                        <option value="outofstock"  {{ isset($data['product']->stock_status) &&  $data['product']->stock_status=="outofstock" ? 'selected': '' }} >Out of Stock</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="rating_count">Rating Count</label>
                    <input type="number" name="rating_count" class="form-control" id="rating_count"  value="{{ $data['product']->rating_count ?? '' }}" >
                </div>
                <div class="form-group col-md-3">
                    <label for="average_rating">Average Rating</label>
                    <input type="number" step="0.01" name="average_rating" class="form-control" id="average_rating"  value="{{ $data['product']->average_rating ?? '' }}" >
                </div>
            </div>

            <!-- Total Sales & Tax -->
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="total_sales">Total Sales</label>
                    <input type="number" name="total_sales" class="form-control" id="total_sales"  value="{{ $data['product']->total_sales ?? '' }}" >
                </div>
                <div class="form-group col-md-4">
                    <label for="tax_status">Tax Status</label>

                        <select class="form-control" id="tax_status" name="tax_status" >
                            <option value="taxable"  {{ isset($data['product']->tax_status) &&  $data['product']->tax_status=="taxable" ? 'selected': '' }} >Taxable</option>
                            <option value="shipping"  {{ isset($data['product']->tax_status) &&  $data['product']->tax_status=="shipping" ? 'selected': '' }} >Shipping Only</option>
                            <option value="none"  {{ isset($data['product']->tax_status) &&  $data['product']->tax_status=="none" ? 'selected': '' }} >None</option>
                        </select>
                    </div>

                <div class="form-group col-md-4">
                    <label for="tax_class">Tax Class</label>
                    <select class="form-control" id="tax_class" name="tax_class">
                        <option value="standard"   {{ isset($data['product']->tax_class) &&  $data['product']->tax_class=="standard" ? 'selected': '' }} >Standard</option>
                        <option value="reduced"   {{ isset($data['product']->tax_class) &&  $data['product']->tax_class=="reduced" ? 'selected': '' }} >Reduced Rate</option>
                        <option value="zero"   {{ isset($data['product']->tax_class) &&  $data['product']->tax_class=="zero" ? 'selected': '' }} >Zero Rate</option>
                        <!-- You can add more custom classes here -->
                    </select>
                </div>
            </div>

            <!-- Categories -->
            <div class="row">
                @if(count($data['category_product']))

                <div class="col-md-1"> <b>Category : </b></div>
                <div class="col-md-11">

                @foreach($data['category_product'] as $category_product)



                        <div class="me-1" id="cat">
                            {{ $category_product->name ?? '' }}
                             <input type="checkbox"
                                   name="category_product_delete[]"
                                   class="form-control2 "
                                   id="category_product_delete_{{ $category_product->id }}"
                                   value="{{ $category_product->id ?? '' }}">



                        </div>

                @endforeach
                    </div>

            @else
                <p>No categories assigned.</p>
            @endif

        </div>

                <div class="form-group col-md-3">
                    <label for="category_product">Add Category</label>
                    <select name="category_product_add" class="form-control">
                        <option value=''>--</option>
                        @foreach($data['categories'] as $categories)
                        <option value="{{$categories->id }}">{{ $categories->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- Dimensions -->
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="weight">Weight</label>
                    <input type="text" name="weight" class="form-control" id="weight"  value="{{ $data['product']->weight ?? '' }}" >
                </div>
                <div class="form-group col-md-3">
                    <label for="length">Length</label>
                    <input type="text" name="length" class="form-control" id="length"  value="{{ $data['product']->length ?? '' }}" >
                </div>
                <div class="form-group col-md-3">
                    <label for="width">Width</label>
                    <input type="text" name="width" class="form-control" id="width"  value="{{ $data['product']->width ?? '' }}" >
                </div>
                <div class="form-group col-md-3">
                    <label for="height">Height</label>
                    <input type="text" name="height" class="form-control" id="height"  value="{{ $data['product']->height ?? '' }}" >
                </div>
            </div>


            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">SEO Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter SEO title"  value="{{ $data['product']->meta_title ?? '' }}" >
                    </div>
                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Enter SEO description"   >{{ $data['product']->meta_description ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Enter keywords, separated by commas"  value="{{ $data['product']->meta_keywords ?? '' }}" >
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug / URL</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="product-slug"  value="{{ $data['product']->slug ?? '' }}" >
                    </div>
                </div>
            </div>


           <input type="hidden"  name="id" value="{{ $data['product']->id ?? '' }}" >


        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save Product</button>
        </div>
    </div>
</form>



@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    <script>
        console.log('Admin Dashboard Loaded');
    </script>
@stop
