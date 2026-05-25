<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <url>
        <loc>https://{{ config('clinic.domain') }}/</loc>
        <lastmod>{{ now()->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
        <image:image>
            <image:loc>https://{{ config('clinic.domain') }}/foto-emily.jpg</image:loc>
            <image:title>Dra. Emily Beatriz — Especialista em Harmonização Facial em Belo Horizonte</image:title>
        </image:image>
        <image:image>
            <image:loc>https://{{ config('clinic.domain') }}/depois-1.jpg</image:loc>
            <image:title>Resultado botox Belo Horizonte — Dra. Emily Beatriz</image:title>
        </image:image>
        <image:image>
            <image:loc>https://{{ config('clinic.domain') }}/depois-2.jpg</image:loc>
            <image:title>Resultado preenchimento labial BH — Dra. Emily Beatriz</image:title>
        </image:image>
        <image:image>
            <image:loc>https://{{ config('clinic.domain') }}/depois-3.jpg</image:loc>
            <image:title>Resultado harmonização facial Belo Horizonte — Dra. Emily Beatriz</image:title>
        </image:image>
    </url>
</urlset>
