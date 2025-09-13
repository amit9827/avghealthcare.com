<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Page;
use App\Models\ShoppingCart;
use App\Models\ShippingAddress;
use App\Models\Order;
use App\Models\Ingredient;
use App\Models\Benefit;

use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class FrontendController extends Controller
{
    //

    public function menu(Request $request){

       /* Home
        Diabetes care
        Cardio Care
        Digestive Care
        Vinegars
        Immunity care
        Liver Care
        Men Wellness
        Women Wellness
        */


        $menu_products = Category::orderby('priority', 'desc')->limit(6)-> get();
        $footer_menu_products = Category::orderby('priority', 'desc')-> get();
        $menu_ingredients = [

            [
                'title' => 'Ingredient',
                'url' => '/products',
                'submenu' => [
                    ['title' => 'Pharma', 'url' => '/products/pharma'],
                    ['title' => 'Healthcare', 'url' => '/products/healthcare'],
                ],
            ],

            [
                'title' => 'Cardio care',
                'url' => '/products',
                'submenu' => [
                    ['title' => 'Pharma', 'url' => '/products/pharma'],
                    ['title' => 'Healthcare', 'url' => '/products/healthcare'],
                ],
            ],

            [
                'title' => 'Digestive care',
                'url' => '/products',
                'submenu' => [
                    ['title' => 'Pharma', 'url' => '/products/pharma'],
                    ['title' => 'Healthcare', 'url' => '/products/healthcare'],
                ],
            ],

            [
                'title' => 'Cart',
                'url' => '/cart',
                'submenu' => [],
            ],
        ];

        $menu_ingredients = Ingredient::orderby('priority', 'desc')->limit(6)->get();

        $menu_quick_links = [
            [
                'title' => 'Home',
                'url' => '/',
                'submenu' => [],
            ],

            [
                'title' => 'About Us',
                'url' => '/page/about',
                'submenu' => [],
            ],

            [
                'title' => 'Contact',
                'url' => '/page/contact',
                'submenu' => [],
            ],




            [
                'title' => 'Privacy Policy',
                'url' => '/page/privacy-policy',
                'submenu' => [],
            ],

            [
                'title' => 'Terms and Conditions',
                'url' => '/page/terms-and-conditions',
                'submenu' => [],
            ],
            [
                'title' => 'Refund & Return Policy',
                'url' => '/page/refund-return-policy',
                'submenu' => [],
            ],
            [
                'title' => 'Shipping Policy',
                'url' => '/page/shipping-policy',
                'submenu' => [],
            ],






            [
                'title' => 'Admin',
                'url' => '/go/admin',
                'submenu' => [],
            ],
        ];

        $menu['footer_menu_products']=$footer_menu_products;
        $menu['menu_products']=$menu_products;
        $menu['menu_ingredients']=$menu_ingredients;
        $menu['menu_quick_links']=$menu_quick_links;

        return response()->json($menu);
    }



public function products_featured(Request $request){

$data['products_featured']=Product::where('featured', 1)->get();
return response()->json($data);


}


public function category_featured(Request $request){

    $data['category_featured']=Category::where('featured', 1)->get();
return response()->json($data);

}

    public function ingredients(Request $request, $ingredient_slug){

          $ingredients = Ingredient::where('slug', $ingredient_slug)->first();
        $subcategories =   [

        ];

        $products =  Product::where('ingredients_tags', 'like', "%$ingredients->name%")->get();
        $data['subcategories'] = $subcategories;
        $data['ingredients'] = $ingredients;
        $data['products'] = $products;

        return response()->json($data);
    }



    public function category(Request $request, $category_slug){

        $category = Category::where('slug', $category_slug)->first();
        $subcategories =   [];


        $products = $category->products;
        $data['subcategories'] = $subcategories;
        $data['category'] = $category;
        $data['products'] = $products;

        return response()->json($data);
    }

    public function product_by_slug(Request $request, $product_slug){

       $product = Product::where('slug', $product_slug)->first();
       $data['product'] = $product;
       $data['additional_product_images'] = $product->additional_product_images;
       $data['additional_banner_images'] = $product->additional_banner_images;



       $benefits = $product->benefits_tags;
       $benefits_array = explode(",", $benefits);

       $data['benefits'] = [];
       if(is_array($benefits_array))
       {
        foreach($benefits_array  as $benefit)
        {
         $benefit = Benefit::where('name', "like" , trim($benefit))->first();
         if($benefit)
         $data['benefits'][] = $benefit;


        }



       }





       return response()->json($data);


    }



    public function page_by_slug(Request $request, $page_slug){

        $page = Page::where('slug', $page_slug)->first();
        $data['page'] = $page;

        return response()->json($data);


     }


  /*   // PhonePeController.php (simplified)
public function createPayment(Request $request)
{
    $token = $this->getPhonePeToken();
    $response = Http::withHeaders([
        'Authorization' => 'O-Bearer ' . $token,
    ])->post('https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/pay', [
        'merchantOrderId' => 'ORD_123' . uniqid(),
        'amount' => 1000,
        'paymentFlow' => ['type' => 'PG_CHECKOUT'],
        'merchantUrls' => ['redirectUrl' => route('phonepe.callback')],
    ]);

    if ($response->successful()) {
        return redirect($response->json()['redirectUrl']);
    }
    abort(500, 'Payment initiation failed.');
}

public function handleCallback(Request $request)
{
    $transactionId = $request->transactionId;
    $statusResponse = $this->verifyPhonePeStatus($transactionId);
    // Update your database and return response to user
}



public function phonepe(Request $request){

    $data=array();

    return view('phonepesample', compact('data'));
}

*/

public function checkout(Request $request)
{

    $customer = Customer::where('email', $request->address['email'])->first();
    if($customer==null)
    $customer = new Customer;

    $customer->name =$request->address['name'];
    $customer->address=$request->address['address'];
    $customer->town=$request->address['town'];
    $customer->pin_code= $request->address['pin_code'];
    $customer->state=$request->address['state'];
    $customer->phone=$request->address['phone'];
    $customer->email=$request->address['email'];
    $customer->save();

    $items = $request->items;
    $session_id = $request->session_id;

    foreach($items as $item)
    {

        $shopping_cart = ShoppingCart::where('session_id', $session_id)->where('product_id', $item['product']['id'] )->first();
        if($shopping_cart==null)
        $shopping_cart = new ShoppingCart;

        $price = $item['product']['regular_price'];
        if ($item['product']['onsale'] == 1) {
            $price = $item['product']['sale_price'];
        }

        $shopping_cart->session_id = $session_id;
        $shopping_cart->customer_id = $customer->id;
        $shopping_cart->product_id = $item['product']['id'];
        $shopping_cart->price = $price;
        $shopping_cart->quantity = $item['quantity'];
        $shopping_cart->amount = $price * $item['quantity'];
        $shopping_cart->total_amount = $request->total_amount;
        $shopping_cart->save();
    }



    $shipping_address = ShippingAddress::where('session_id', $session_id)->first();
    if($shipping_address==null)
    $shipping_address = new ShippingAddress;

    $shipping_address->session_id = $session_id;
    $shipping_address->customer_id =$customer->id;
    $shipping_address->name =$request->shipping_address['name'];
    $shipping_address->address=$request->shipping_address['address'];
    $shipping_address->town=$request->shipping_address['town'];
    $shipping_address->pin_code= $request->shipping_address['pin_code'];
    $shipping_address->state=$request->shipping_address['state'];
    $shipping_address->phone=$request->shipping_address['phone'];
    $shipping_address->email=$request->shipping_address['email'];
    $shipping_address->save();


    $order = Order::where('shopping_cart_session_id', $session_id)->first();
    if($order==null)
    $order = new Order;

    $order->customer_id =  $customer->id;
    $order->shopping_cart_session_id = $session_id;
    $order->total_amount =$request->total_amount;
    $order->order_status = "DRAFT";
    $order->dispatch_status = "PENDING";
    $order->payment_mode = "COD";
    $order->txn_id = "COD-".time();
    $order->shipping_fee = $request->shipping_fee;
    $order->payment_fee = $request->payment_fee;
    $order->save();

    $data['order_saved']=1;
    $data['order_id']=$order->id;
    $data['txn_id']=$order->txn_id;
    return response()->json($data);

}


public function min_order_amount(Request $request){
     return response()->json([
        'min_order_amount' => config('avg_config.min_free_shopping_order_amount')
    ]);
}

public function getOrderStatus(Request $request)
{
    $orderId = $request->session()->get('order_id');
    $status  = $request->session()->get('order_status');

    return response()->json([
        'orderId' => $orderId,
        'status'  => $status
    ]);
}

public function order_status(Request $request, $txn_id){
    //$orderId = $request->session()->get('order_id');
    $path= url("/order/$txn_id");
    return redirect($path);
}

public function order_detail(Request $request, $txn_id){


    $data['order'] = Order::where('txn_id', $txn_id)->first();
    $data['shopping_cart_items'] =  $data['order']->shopping_cart_items;
    foreach( $data['shopping_cart_items'] as $shopping_cart_item )
    $shopping_cart_item['product'] =  $shopping_cart_item->product;

    $data['customer'] =  $data['order']->customer;
    return $data;


}




}
