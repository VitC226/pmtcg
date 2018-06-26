<?xml version="1.0" encoding="utf-8"?>
<urlset>
    @foreach ($posts as $post)
    <url>
        <loc>http://pmtcgo.com/card/{{ $post->img }}</loc>
        <lastmod>{{ $post->releaseDate }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    @endforeach
</urlset>