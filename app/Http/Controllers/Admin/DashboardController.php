<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Page;

use App\Models\BannerImage;
use App\Models\ProductImage;

use Illuminate\Validation\Rule;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Customer;

use App\Models\Ingredient;
use App\Models\Benefit;

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
        $data['category_product'] = array();

        return view('admin.product', compact('data'));
    }

    public function product_get(Request $request, $id)
    {
        $data['categories'] = Category::get();
        $data['product'] = Product::find($id);
        $data['ingredients'] = Ingredient::get();
        $data['benefits'] = Benefit::get();

       $data['category_product'] = $data['product']->categories;


        if($data['product']==null)
        return redirect()->back()->with('error', "Invalid Products");

        return view('admin.product', compact('data'));
    }

    public function product_delete(Request $request, $delete_id)
    {
        $data['product'] = Product::find($delete_id);
        if($data['product']==null)
        return redirect()->back()->with('error', "Invalid Products");

        $name=$data['product']->title;
        $data['product']->delete();
        return redirect()->back()->with('success', "Product Deleted : $name");


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
    $validated['onsale'] = $request->input('onsale', 0);

    // Create product (fillable fields should be defined in Product model)
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


    if($request->hasFile('featured_image')) {
        $file = $request->file('featured_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs("products/{$product->id}", $filename, 'public');
        $product->featured_image = $path;
    }


    if($request->filled('featured_image_delete')) {
        $path = $request->input('featured_image_delete');

        // Delete file from storage
        if(Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Remove path from product
        $product->featured_image = '';
        $product->save();
    }



    if($request->hasFile('banner_image')) {

        $file = $request->file('banner_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs("products/{$product->id}", $filename, 'public');
        $product->banner_image = $path;
    }

    if($request->filled('banner_image_delete')) {
        $path = $request->input('banner_image_delete');

        // Delete file from storage
        if(Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Remove path from product
        $product->banner_image = '';
        $product->save();
    }




    $product->save();



    $uploadedFiles = [];

    if ($request->hasFile('additional_product_image')) {
        foreach ($request->file('additional_product_image') as $file) {
            if ($file && $file->isValid()) {

                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs("products/{$product->id}", $filename, 'public');

                $BannerImage = new ProductImage;
        $BannerImage->product_id = $product->id;
        $BannerImage->path = $path;
        $BannerImage->name = $filename;
        $BannerImage->save();


            }
        }
    }




    $additional_product_image_delete = $request->input('additional_product_image_delete');
    if($additional_product_image_delete!=''){
        foreach($additional_product_image_delete as $id)
        {
            $BannerImage = ProductImage::find($id);
            $path = $BannerImage->path;
            if(Storage::disk('public')->exists($path)){
                Storage::disk('public')->delete($path);
            };
            $BannerImage->delete();
        }

    };



    if ($request->hasFile('additional_banner_image')) {
        foreach ($request->file('additional_banner_image') as $file) {
            if ($file && $file->isValid()) {

                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs("products/{$product->id}", $filename, 'public');

                $BannerImage = new BannerImage;
                $BannerImage->product_id = $product->id;
                $BannerImage->path = $path;
                $BannerImage->name = $filename;
                $BannerImage->save();


            }
        }
    }


    $additional_banner_image_delete = $request->input('additional_banner_image_delete');
    if($additional_banner_image_delete!=''){
        foreach($additional_banner_image_delete as $id)
        {
            $BannerImage = BannerImage::find($id);
            $path = $BannerImage->path;
            if(Storage::disk('public')->exists($path)){
                Storage::disk('public')->delete($path);
            }
            $BannerImage->delete();
        }
    };


  //  $product->categories()->sync($request->category_ids ?? []);

  //  return redirect()->route('admin.products')->with('success', 'Product created/upated successfully.');
    return redirect()->back()->with('success', 'Product created/upated successfully.');
}


public function ingredients()
{
    $data['all_ingredients'] = Ingredient::get();

    $data['ingredients'] = Ingredient::paginate($this->pagevalue);
    return view('admin.ingredients', compact('data'));
}

public function ingredient()
{
    $data['all_ingredients'] = Ingredient::get();

    $data['ingredients'] = Ingredient::paginate($this->pagevalue);
    return view('admin.ingredient', compact('data'));
}

public function ingredient_store(Request $request)
{

// Validation rules
$validated = $request->validate([
    'name'        => 'required|string|max:255',
    'slug'        => 'nullable|string|unique:ingredients,slug,' . $request->ingredient_id,
    'description' => 'nullable|string',
    'image_path'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    'parent_id'   => 'nullable|integer|exists:ingredients,id',
]);

// Auto-generate slug if not given
if (empty($validated['slug'])) {
    $validated['slug'] = Str::slug($validated['name']);
}

// Handle image upload
if ($request->hasFile('image_path')) {
    $validated['image_path'] = $request->file('image_path')->store('ingredients', 'public');
}

// ✅ Update or Create ingredient
if ($request->ingredient_id) {
    $ingredient = ingredient::findOrFail($request->ingredient_id);
    $ingredient->update($validated);
    $message = 'ingredient updated successfully.';
} else {
    $ingredient = ingredient::create($validated);
    $message = 'ingredient created successfully.';
}

return redirect()->route('admin.ingredients')->with('success', $message);

}

public function ingredient_get(Request $request,  $ingredient_id)
{

    $data['ingredient'] =      Ingredient::find($ingredient_id)   ;
    $data['all_ingredients'] = Ingredient::get();

    return view('admin.ingredient', compact('data'));
}

public function ingredient_delete(Request $request,  $ingredient_id)
{
    $data['ingredient'] =      Ingredient::find($ingredient_id)   ;
    if($data['ingredient']==null)
    return redirect()->back()->with('error', "Ingredient ingredient");

    $name=$data['ingredient']->title;
    $data['ingredient']->delete();
    return redirect()->back()->with('success', "Ingredient Deleted : $name");

}
public function categories()
{

    $data['categories'] = Category::paginate($this->pagevalue);
    return view('admin.categories', compact('data'));
}

public function pages()
{
    $data['pages'] = Page::paginate($this->pagevalue);
    return view('admin.pages', compact('data'));

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

public function category_delete(Request $request, $delete_id)
{
    $data['category'] = Category::find($delete_id);
    if($data['category']==null)
    return redirect()->back()->with('error', "Invalid Category");

    $name=$data['category']->title;
    $data['category']->delete();
    return redirect()->back()->with('success', "Category Deleted : $name");


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
    'featured' => 'nullable|string',
    'visibility' => 'nullable|string',
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


public function page()
{

$data=array();

    return view('admin.page', compact('data'));
}


public function page_get(Request $request, $id)
{

$data=array();


$data['page'] = Page::find($id);
if($data['page']==null)
return redirect()->back()->with('error', "Page not found");


return view('admin.page', compact('data'));
}



public function page_store(Request $request){


    if (!Auth::check()) {
        return redirect()->back()->with('error', "Not Logged In");
    }

    $user = Auth::user();

// Validation rules
$validated = $request->validate([
    'title'        => 'required|string|max:255',
    'slug'        => 'nullable|string|unique:categories,slug,' . $request->page_id,
    'description' => 'nullable|string',
    'long_description' => 'nullable|string',
    'featured_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

    'meta_title' => 'nullable|string',
    'meta_description' => 'nullable|string',
    'meta_keywords' => 'nullable|string',


]);


$validated['created_by'] = $user->id;

// Auto-generate slug if not given
if (empty($validated['slug'])) {
    $validated['slug'] = Str::slug($validated['title']);
}

// Handle image upload
if ($request->hasFile('featured_image')) {
    $validated['featured_image'] = $request->file('featured_image')->store('page', 'public');
}

// ✅ Update or Create category
if ($request->page_id) {
    $page = Page::findOrFail($request->page_id);
    $page->update($validated);
    $message = 'Page updated successfully.';
} else {
    $page = Page::create($validated);
    $message = 'Page created successfully.';
}

return redirect()->route('admin.pages')->with('success', $message);



}


public function page_delete(Request $request, $delete_id){

    $page = Page::find($delete_id);
    if($page==null)
        return redirect()->back()->with('error', "Page not found");

    $page->delete();
    return redirect()->back()->with('success', "Page deleted Successfully");

}

public function orders(Request $request){

    $orders = Order::orderby('created_at', 'desc')->get();
     $data['orders'] = $orders;

    return view('admin.orders', compact('data'));
}

public function customers(Request $request){

    $customers = Customer::orderby('name', 'desc')->get();
    $data['customers'] = $customers;

    return view('admin.customers', compact('data'));

}



public function benefits()
{
    $data['all_benefits'] = benefit::get();

    $data['benefits'] = benefit::paginate($this->pagevalue);
    return view('admin.benefits', compact('data'));
}

public function benefit()
{
    $data['all_benefits'] = benefit::get();

    $data['benefits'] = benefit::paginate($this->pagevalue);
    return view('admin.benefit', compact('data'));
}

public function benefit_store(Request $request)
{

// Validation rules
$validated = $request->validate([
    'name'        => 'required|string|max:255',
    'slug'        => 'nullable|string|unique:benefits,slug,' . $request->benefit_id,
    'description' => 'nullable|string',
    'image_path'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    'parent_id'   => 'nullable|integer|exists:benefits,id',
]);

// Auto-generate slug if not given
if (empty($validated['slug'])) {
    $validated['slug'] = Str::slug($validated['name']);
}

// Handle image upload
if ($request->hasFile('image_path')) {
    $validated['image_path'] = $request->file('image_path')->store('benefits', 'public');
}

// ✅ Update or Create benefit
if ($request->benefit_id) {
    $benefit = benefit::findOrFail($request->benefit_id);
    $benefit->update($validated);
    $message = 'benefit updated successfully.';
} else {
    $benefit = benefit::create($validated);
    $message = 'benefit created successfully.';
}

return redirect()->route('admin.benefits')->with('success', $message);

}

public function benefit_get(Request $request,  $benefit_id)
{

    $data['benefit'] =      benefit::find($benefit_id)   ;
    $data['all_benefits'] = benefit::get();

    return view('admin.benefit', compact('data'));
}

public function benefit_delete(Request $request,  $benefit_id)
{
    $data['benefit'] =      benefit::find($benefit_id)   ;
    if($data['benefit']==null)
    return redirect()->back()->with('error', "benefit benefit");

    $name=$data['benefit']->title;
    $data['benefit']->delete();
    return redirect()->back()->with('success', "benefit Deleted : $name");

}


public function order_get(Request $request,  $order_id)
{
    $data['order'] = Order::find($order_id);
    if($data['order']==null)
    return redirect()->back()->with('error', "Order not found");

    return view('admin.order', compact('data'));



}



public function order_update(Request $request,  $order_id)
{
    $data['order'] = Order::find($order_id);
    if($data['order']==null)
    return redirect()->back()->with('error', "Order not found");

    $data['order']->order_status = $request->order_status;
    $data['order']->dispatch_status = $request->dispatch_status;

    $update = [
        'order_status' => $request->order_status,
        'dispatch_status' => $request->dispatch_status,


    ];
    $data['order']->update($update);

    return redirect()->back()->with('success', "Order updated");



}

public function order_delete(Request $request,  $order_id){

$data['order'] = Order::find($order_id);
if($data['order']==null)
return redirect()->back()->with('error', "Order not found");
$data['order']->delete();
return redirect()->back()->with('success', "Order deleted");




}


}
