<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;

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
                'title' => 'About Us',
                'url' => '/about',
                'submenu' => [],
            ],
            [
                'title' => 'Cart',
                'url' => '/cart',
                'submenu' => [],
            ],
        ];
        $menu_quick_links = [
            [
                'title' => 'Home',
                'url' => '/',
                'submenu' => [],
            ],
            [
                'title' => 'Diabetes care',
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
                'title' => 'About Us',
                'url' => '/about',
                'submenu' => [],
            ],
            [
                'title' => 'Admin',
                'url' => '/go/admin',
                'submenu' => [],
            ],
        ];

        $menu['menu_products']=$menu_products;
        $menu['menu_ingredients']=$menu_ingredients;
        $menu['menu_quick_links']=$menu_quick_links;

        return response()->json($menu);
    }

    public function category(Request $request, $category_slug){

        $category = Category::where('slug', $category_slug)->first();
        $subcategories =   [
            [
                'title' => 'Bath Wash',
                'url' => "/category/$category_slug/bath-body",
                'submenu' => [],
            ],
            [
                'title' => 'Bath Wash',
                'url' => "/category/$category_slug/bath-wash",
                'submenu' => [],
            ],
            [
                'title' => 'Bath Lotion',
                'url' => "/category/$category_slug/bath-Lotion",
                'submenu' => [],
            ],
        ];

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
       return response()->json($data);


    }
}
