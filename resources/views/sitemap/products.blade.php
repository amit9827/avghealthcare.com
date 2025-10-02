@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    @foreach($products as $product)
    <url>
        <loc>{{ url('/product/' . $product->slug) }}</loc>
        <lastmod>{{ \Carbon\Carbon::parse($product->updated_at)->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>
            {{ number_format(
                min(max($product->priority ?? 0.5, 0.0), 1.0), 1
            ) }}
        </priority>

        @if($product->featured_image)
        <image:image>
            <image:loc>{{ url('/') }}/images/{{ $product->featured_image }}</image:loc>
            <image:title>{{ $product->title }}</image:title>
        </image:image>
        @endif
    </url>
    @endforeach

</urlset>
