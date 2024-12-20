<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($brands as $brand)
        <url>
            <loc>{{?LaravelLocalization::localizeUrl("brand/".$brand->link) }}</loc>
            <lastmod>{{ $brand->created_at->tz("UTC")->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>