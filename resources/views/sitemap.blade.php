<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($locs as $locItem)
        <url>
            <loc>{{$locItem['loc']}}</loc>
            <lastmod>{{$locItem['lastmod']}}</lastmod>
        </url>
    @endforeach
</urlset>
