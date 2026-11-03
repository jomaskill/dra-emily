<?php

namespace App\Support;

class SiteSchema
{
    /**
     * The professional behind the site. Every page describes her the same way,
     * so search engines can tie the articles to one author.
     *
     * @return array<string, mixed>
     */
    public static function person(): array
    {
        $siteUrl = self::siteUrl();

        return [
            '@type' => 'Person',
            '@id' => $siteUrl.'/#emily',
            'name' => 'Dra. Emily Beatriz',
            'jobTitle' => 'Cirurgiã-Dentista — Especialista em Harmonização Orofacial',
            'hasOccupation' => ['@type' => 'Occupation', 'name' => 'Cirurgiã-dentista'],
            'identifier' => 'CRO '.config('clinic.cro'),
            'url' => $siteUrl.'/dra-emily-beatriz',
            'image' => $siteUrl.'/foto-emily.jpg',
            'sameAs' => ['https://www.instagram.com/'.config('clinic.instagram').'/'],
            'worksFor' => self::clinic(),
        ];
    }

    /**
     * The clinic as named on the homepage. Pages other than the homepage repeat
     * it because a bare @id reference does not resolve outside the page that
     * defines it.
     *
     * @return array<string, mixed>
     */
    public static function clinic(): array
    {
        $siteUrl = self::siteUrl();

        return [
            '@type' => 'Dentist',
            '@id' => $siteUrl.'/#clinic',
            'name' => 'Dra. Emily Beatriz — Harmonização Facial',
            'url' => $siteUrl.'/',
            'logo' => $siteUrl.'/logo.png',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function website(): array
    {
        $siteUrl = self::siteUrl();

        return [
            '@type' => 'WebSite',
            '@id' => $siteUrl.'/#website',
            'name' => 'Dra. Emily Beatriz — Harmonização Facial',
            'url' => $siteUrl.'/',
        ];
    }

    /**
     * Encode a value for a JSON-LD block.
     */
    public static function json(mixed $value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private static function siteUrl(): string
    {
        return 'https://'.config('clinic.domain');
    }
}
