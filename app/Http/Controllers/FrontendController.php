<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                'title' => 'Contact',
                'url' => '/contact',
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
        ];

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

        $data['subcategories'] = $subcategories;
        $data['category'] = $category;

        return response()->json($data);
    }
}
