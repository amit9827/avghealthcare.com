@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    @foreach($categories as $category)
    <url>
        <loc>{{ url('/category/' . $category->slug) }}</loc>
        <lastmod>{{ \Carbon\Carbon::parse($category->updated_at)->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>
            {{ number_format(
                min(max($category->priority ?? 0.5, 0.0), 1.0), 1
            ) }}
        </priority>

        @if($category->image_path)
        <image:image>
            <image:loc>{{ url('/') }}/images/{{ $category->image_path }}</image:loc>
            <image:title>{{ $category->name }}</image:title>
        </image:image>
        @endif
    </url>
    @endforeach

</urlset>
