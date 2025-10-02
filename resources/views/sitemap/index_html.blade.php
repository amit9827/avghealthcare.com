<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Map | AVG Healthcare</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #2c3e50; }
        ul { list-style-type: none; padding-left: 0; }
        li { margin-bottom: 5px; }
        a { color: #2980b9; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Site Map</h1>
    <p><a href="{{ url('/') }}">Home</a></p>


    {{-- Categories --}}
    <h2>Categories</h2>
    <ul>
        @foreach($sitemap_data['categories'] ?? [] as $category)
            <li>
                <a href="{{ url('/category/'.$category['slug']) }}">{{ $category['name'] }}</a>
            </li>
        @endforeach
    </ul>
    <p><a href="{{ route('sitemap_categories_html') }}">All Categories</a></p>

    {{-- Products --}}
    <h2>Products</h2>
    <ul>
        @foreach($sitemap_data['products'] ?? [] as $product)
            <li>
                <a href="{{ url('/product/'.$product['slug']) }}">{{ $product['title'] }}</a>
            </li>
        @endforeach
    </ul>
    <p><a href="{{ route('sitemap_products_html') }}">All Products</a></p>

    {{-- Blog --}}
    <h2>Blog</h2>
    <ul>
        <li><a href="{{ url('/blog') }}">Visit our Blog</a></li>
    </ul>




</body>
</html>
