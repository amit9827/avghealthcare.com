@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- WordPress Blog Sitemap --}}
    <sitemap>
        <loc>{{ url('/blog/post-sitemap.xml') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>

    {{-- Categories --}}
    @for($i = 1; $i <= $categoryPages; $i++)
    <sitemap>
        <loc>{{ url("/sitemap-categories/{$i}") }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endfor

    {{-- Products --}}
    @for($i = 1; $i <= $productPages; $i++)
    <sitemap>
        <loc>{{ url("/sitemap-products/{$i}") }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endfor

</sitemapindex>
