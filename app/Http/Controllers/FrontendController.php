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


        $menu_products = [

            [
                'title' => 'Diabetes care',
                'url' => '/category/diabetic-care',
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
                'title' => 'Contact',
                'url' => '/contact1',
                'submenu' => [],
            ],
        ];

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


        $category = [
            'title' => 'Bath Body',
            'slug' => $category_slug,
        ];

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
        $products_x = [
            [
                'id' => 1,
                'title' => "Shea Butter And Cocoa Butter With Lactic Acid Bodu Lotion - 400ml",
                'category' => "Bath Body",
                'subcategory' => "Hair Fall, Weak & Damaged Hair",

                'category_2' => "Bath Body",
                'subcategory_2' => "Hair Fall, Weak & Damaged Hair",

                'category_3' => "Bath Body",
                'subcategory_3' => "Hair Fall, Weak & Damaged Hair",

                'category_4' => "Bath Body",
                'subcategory_4' => "Hair Fall, Weak & Damaged Hair",

                'category_5' => "Bath Body",
                'subcategory_5' => "Hair Fall, Weak & Damaged Hair",

                'tags' => "Retain Hydration,Repair Damage Skin, Boost Collagen",
                'benefits' => "Retain Hydration,Repair Damage Skin, Boost Collagen",

                'price' => "399.00",
                'currency' => "INR",
                'stock_quantity' => 10,
                'rating' => 4.50,
                'reviews' => 144,
                'path' => 'products\1.jpg',


            ],

            [
                'id' => 2,
                'title' => "Shea Butter And Cocoa Butter With Lactic Acid Bodu Lotion - 400ml",
                'category' => "Bath Body",
                'subcategory' => "Hair Fall, Weak & Damaged Hair",

                'category_2' => "Bath Body",
                'subcategory_2' => "Hair Fall, Weak & Damaged Hair",

                'category_3' => "Bath Body",
                'subcategory_3' => "Hair Fall, Weak & Damaged Hair",

                'category_4' => "Bath Body",
                'subcategory_4' => "Hair Fall, Weak & Damaged Hair",

                'category_5' => "Bath Body",
                'subcategory_5' => "Hair Fall, Weak & Damaged Hair",

                'tags' => "Retain Hydration,Repair Damage Skin, Boost Collagen",
                'benefits' => "Retain Hydration,Repair Damage Skin, Boost Collagen",


                'price' => "399.00",
                'currency' => "INR",
                'stock_quantity' => 10,
                'rating' => 4.50,
                'reviews' => 144,
                'path' => 'products\1.jpg',


            ],
            [
                'id' => 3,
                'title' => "Shea Butter And Cocoa Butter With Lactic Acid Bodu Lotion - 400ml",
                'category' => "Bath Body",
                'subcategory' => "Hair Fall, Weak & Damaged Hair",

                'category_2' => "Bath Body",
                'subcategory_2' => "Hair Fall, Weak & Damaged Hair",

                'category_3' => "Bath Body",
                'subcategory_3' => "Hair Fall, Weak & Damaged Hair",

                'category_4' => "Bath Body",
                'subcategory_4' => "Hair Fall, Weak & Damaged Hair",

                'category_5' => "Bath Body",
                'subcategory_5' => "Hair Fall, Weak & Damaged Hair",

                'tags' => "Retain Hydration,Repair Damage Skin, Boost Collagen",
                'benefits' => "Retain Hydration,Repair Damage Skin, Boost Collagen",


                'price' => "399.00",
                'currency' => "INR",
                'stock_quantity' => 10,
                'rating' => rand(0.01, 4.99),
                'reviews' => rand(99,1005),
                'path' => 'products\1.jpg',


            ],
            [
                'id' => 4,
                'title' => "Shea Butter And Cocoa Butter With Lactic Acid Bodu Lotion - 400ml",
                'category' => "Bath Body",
                'subcategory' => "Hair Fall, Weak & Damaged Hair",

                'category_2' => "Bath Body",
                'subcategory_2' => "Hair Fall, Weak & Damaged Hair",

                'category_3' => "Bath Body",
                'subcategory_3' => "Hair Fall, Weak & Damaged Hair",

                'category_4' => "Bath Body",
                'subcategory_4' => "Hair Fall, Weak & Damaged Hair",

                'category_5' => "Bath Body",
                'subcategory_5' => "Hair Fall, Weak & Damaged Hair",

                'tags' => "Retain Hydration,Repair Damage Skin, Boost Collagen",
                'benefits' => "Retain Hydration,Repair Damage Skin, Boost Collagen",


                'price' => "399.00",
                'currency' => "INR",
                'stock_quantity' => 10,
                'rating' => 4.50,
                'reviews' => 144,
                'path' => 'products\1.jpg',


            ]



            ];

        $data['subcategories'] = $subcategories;
        $data['category'] = $category;
        $data['products'] = $products;



        return response()->json($data);
    }
}
