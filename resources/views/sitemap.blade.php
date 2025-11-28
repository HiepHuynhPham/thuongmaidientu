@php echo '<' . '?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($pages as $page)
    <url>
        <loc>{{ $page['loc'] }}</loc>
        <changefreq>weekly</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach
    @foreach($products as $product)
    <url>
        <loc>{{ route('product.detail', ['slug' => $product->slug]) }}</loc>
        <lastmod>{{ optional($product->updated_at ?? $product->created_at)->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.80</priority>
    </url>
    @endforeach
</urlset>
