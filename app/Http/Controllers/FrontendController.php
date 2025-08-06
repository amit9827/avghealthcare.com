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
                'title' => 'Contact',
                'url' => '/contact',
                'submenu' => [],
            ],
        ];

        $menu['menu_products']=$menu_products;
        $menu['menu_ingredients']=$menu_ingredients;
        $menu['menu_quick_links']=$menu_quick_links;

        return response()->json($menu);
    }
}
