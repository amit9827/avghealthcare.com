<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products Sitemap | AVG Healthcare</title>
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
    <h1>Products Sitemap</h1>
    <p><a href="{{ url('/') }}">Home</a></p>

    <ul>
        @foreach($sitemap_data['products'] ?? [] as $product)
            <li>
                <a href="{{ url('/product/'.$product['slug']) }}">
                    {{ $product['title'] }}
                </a>
            </li>
        @endforeach
    </ul>

</body>
</html>
