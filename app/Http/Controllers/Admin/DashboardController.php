<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryProduct;


use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class DashboardController extends Controller
{

    public $pagevalue = 25;
    public function index()
    {
        return view('admin.dashboard');
    }




public function showImage($path)
{
    // Check if file exists in the 'public' disk
    if (!Storage::disk('public')->exists($path)) {
        abort(404, 'File not found.');
    }

    // Get the file's contents
    $file = Storage::disk('public')->get($path);

    // Get MIME type
    $type = Storage::disk('public')->mimeType($path);

    // Return file as response
    return response($file, 200)
            ->header('Content-Type', $type);
}



    public function posts()
    {
        return view('admin.posts');
    }

    public function product()
    {

        $data['categories'] = Category::get();

        return view('admin.product', compact('data'));
    }

    public function product_get(Request $request, $id)
    {
        $data['categories'] = Category::get();
        $data['product'] = Product::find($id);


       $data['category_product'] = $data['product']->categories;


        if($data['product']==null)
        return redirect()->back()->with('error', "Invalid Products");

        return view('admin.product', compact('data'));
    }

    public function products()
    {
        $data['categories'] = Category::get();

        $data['products'] = Product::get();

        return view('admin.products', compact('data'));
    }

    public function product_store(Request $request)
{

    $validated = $request->validate([
        'title'             => 'required|string|max:255',
        'description'       => 'nullable|string',
        'long_description'  => 'nullable|string',
        'ingredients'       => 'nullable|string',
        'ingredients_tags'  => 'nullable|string',
        'benefits'          => 'nullable|string',
        'benefits_tags'     => 'nullable |String',

        'sku' => [
            'nullable',
            'string',
            Rule::unique('products', 'sku')->ignore($request->id),
        ],


        'min_price'         => 'nullable|numeric',
        'max_price'         => 'nullable|numeric',
        'regular_price'     => 'nullable|numeric',
        'sale_price'        => 'nullable|numeric',
        'sale_start_date'   => 'nullable|string',
        'sale_end_date'     => 'nullable|string',
        'onsale'            => 'boolean',
        'visibility'        => 'boolean',
        'featured'          => 'boolean',
        'product_type'      => 'nullable|string',
        'slug'              => 'nullable|string',
        'stock_quantity'    => 'nullable|integer',
        'stock_status'      => 'nullable|string',
        'rating_count'      => 'nullable|integer',
        'average_rating' => 'nullable|numeric|min:0|max:6',
        'total_sales'       => 'nullable|integer',
        'tax_status'        => 'nullable|string',
        'tax_class'         => 'nullable|string',
        'weight'            => 'nullable|string',
        'length'            => 'nullable|string',
        'width'             => 'nullable|string',
        'height'            => 'nullable|string',
        'meta_title'        => 'nullable|string',
        'meta_description'  => 'nullable|string',
        'meta_keywords'     => 'nullable|string',
        'featured_image' => 'nullable|file',
        'benefit_image' => 'nullable|file',
        'banner_image' => 'nullable|file',
    ]);

    // Create product (fillable fields should be defined in Product model)


    if($request->hasFile('featured_image')) {
        $path = $request->file('featured_image')->store('products', 'public');
        $validated['featured_image'] = $path;
    }

    if($request->hasFile('benefit_image')) {
        $path = $request->file('benefit_image')->store('products', 'public');
        $validated['benefit_image'] = $path;
    }


    if($request->hasFile('banner_image')) {
        $path = $request->file('banner_image')->store('products', 'public');
        $validated['banner_image'] = $path;
    }


    // Auto-generate slug if not given
if (empty($validated['slug'])) {
    $validated['slug'] = Str::slug($validated['title']);
}


    if($request->id!='')
    {
          $product = Product::find($request->id);
          if($product==null)
          return redirect()->back()->with('error', "Invalid ID");

          $product_created = $product->update($validated);

    }else{

         $product = Product::create($validated);

    };

    if($request->category_product_add!='')
    {
        $category_product = CategoryProduct::where('category_id', $request->category_product_add)->where('product_id', $product->id)->first();
        if(!$category_product)
        {
            $category_product = new CategoryProduct;
            $category_product->category_id = $request->category_product_add;
            $category_product->product_id = $product->id;
            $category_product->save();
        }

    }

    $category_product_delete = $request->category_product_delete;

    if(is_array($category_product_delete))
    {

        foreach($category_product_delete as $category_id)
        $category_product  = CategoryProduct::where('product_id', $product->id) ->where('category_id', $category_id)->delete();
    }

  //  $product->categories()->sync($request->category_ids ?? []);

    return redirect()->back()->with('success', 'Product created/upated successfully.');
}


public function categories()
{

    $data['categories'] = Category::paginate($this->pagevalue);

    return view('admin.categories', compact('data'));
}

public function category()
{
    $data['all_categories'] = Category::get();

    return view('admin.category', compact('data'));
}

public function category_get(Request $request,  $category_id)
{

    $data['category'] =      Category::find($category_id)   ;
    $data['all_categories'] = Category::get();

    return view('admin.category', compact('data'));
}

public function category_store(Request $request)
{

// Validation rules
$validated = $request->validate([
    'name'        => 'required|string|max:255',
    'slug'        => 'nullable|string|unique:categories,slug,' . $request->category_id,
    'description' => 'nullable|string',
    'image_path'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    'parent_id'   => 'nullable|integer|exists:categories,id',
]);

// Auto-generate slug if not given
if (empty($validated['slug'])) {
    $validated['slug'] = Str::slug($validated['name']);
}

// Handle image upload
if ($request->hasFile('image_path')) {
    $validated['image_path'] = $request->file('image_path')->store('categories', 'public');
}

// ✅ Update or Create category
if ($request->category_id) {
    $category = Category::findOrFail($request->category_id);
    $category->update($validated);
    $message = 'Category updated successfully.';
} else {
    $category = Category::create($validated);
    $message = 'Category created successfully.';
}

return redirect()->route('admin.categories')->with('success', $message);

}




}
