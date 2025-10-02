<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Page;

use App\Models\BannerImage;
use App\Models\ProductImage;

use App\Models\Order;
use App\Models\Customer;

use App\Models\Ingredient;
use App\Models\Benefit;
use App\Helpers\Helper;

class SitemapController extends Controller
{
    protected $perPage = 50000; // Google max URLs per sitemap

    // ===============================
    // XML Sitemaps
    // ===============================

    // Sitemap index
    public function index()
    {
        $productCount = Product::where('visibility', '!=', 'hidden')->count();
        $categoryCount = Category::where('visibility', '!=', 'hidden')->count();

        $productPages = ceil($productCount / $this->perPage);
        $categoryPages = ceil($categoryCount / $this->perPage);

        $content = view('sitemap.index', compact('productPages', 'categoryPages'));

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    // Products sitemap per page
    public function products($page = 1)
    {
        $products = Product::where('visibility', '!=', 'hidden')
            ->orderBy('updated_at', 'desc')
            ->offset(($page - 1) * $this->perPage)
            ->limit($this->perPage)
            ->get();

        $content = view('sitemap.products', compact('products'));

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    // Categories sitemap per page
    public function categories($page = 1)
    {
        $categories = Category::where('visibility', '!=', 'hidden')
            ->orderBy('updated_at', 'desc')
            ->offset(($page - 1) * $this->perPage)
            ->limit($this->perPage)
            ->get();

        $content = view('sitemap.categories', compact('categories'));

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    // ===============================
    // HTML Sitemaps
    // ===============================

    // Full HTML sitemap (index)
    public function index_html()
    {
        $categories = Category::where('visibility', '!=', 'hidden')->orderBy('priority','desc')
            ->orderBy('name')
            ->limit(100)->get();

        $products = Product::where('visibility', '!=', 'hidden')->orderBy('priority','desc')
            ->orderBy('title')
            ->limit(100)->get();

        $sitemap_data = [
            'categories' => $categories,
            'products' => $products,
        ];

        return response(
            view('sitemap.index_html', compact('sitemap_data')),
            200
        )->header('Content-Type', 'text/html');
    }

    // Products HTML sitemap (paginated)
    public function products_html($page = 1)
    {
        $products = Product::where('visibility', '!=', 'hidden')->orderBy('priority','desc')
            ->orderBy('title')
            ->offset(($page - 1) * $this->perPage)
            ->limit($this->perPage)
            ->get();

        $sitemap_data = [
            'products' => $products,
        ];

        return response(
            view('sitemap.products_html', compact('sitemap_data')),
            200
        )->header('Content-Type', 'text/html');
    }

    // Categories HTML sitemap (paginated)
    public function categories_html($page = 1)
    {
        $categories = Category::where('visibility', '!=', 'hidden')->orderBy('priority','desc')
            ->orderBy('name')
            ->offset(($page - 1) * $this->perPage)
            ->limit($this->perPage)
            ->get();

        $sitemap_data = [
            'categories' => $categories,
        ];

        return response(
            view('sitemap.categories_html', compact('sitemap_data')),
            200
        )->header('Content-Type', 'text/html');
    }
}
