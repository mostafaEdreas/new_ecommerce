<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($products as $product)
        <url>
            <loc>{{ LaravelLocalization::localizeUrl("product/".$product->link) }}</loc>
            <lastmod>{{ $product->created_at->tz("UTC")->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>