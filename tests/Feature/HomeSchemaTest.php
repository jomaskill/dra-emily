<?php

/**
 * Guards the homepage JSON-LD against the two defects found in the
 * 2026-09-07 SEO/GEO/AEO audit:
 *
 *  1. FAQPage markup drifting away from the visible #faq copy (7 of 8
 *     questions had diverged), which forfeits rich-result eligibility and
 *     lets AI engines cite answers the page does not contain.
 *  2. Self-serving aggregateRating/review markup on the clinic's own site,
 *     which is outside Google's structured data policy.
 *
 * Both are prevented at the source by config/faq.php feeding the visible
 * section and the schema alike. These tests keep it that way.
 */

/**
 * @return array<int, mixed>
 */
function homeJsonLd(string $html): array
{
    expect($html)->toContain('application/ld+json');

    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);

    $decoded = json_decode($m[1], true);

    expect(json_last_error())->toBe(JSON_ERROR_NONE, 'Homepage JSON-LD must be valid JSON');

    return $decoded;
}

/**
 * @param  array<int, mixed>  $nodes
 * @return array<string, mixed>
 */
function schemaNode(array $nodes, string $type): array
{
    $node = collect($nodes)->firstWhere('@type', $type);

    expect($node)->not->toBeNull("Homepage JSON-LD must contain a {$type} node");

    return $node;
}

/**
 * @return array<int, string>
 */
function visibleFaqQuestions(string $html): array
{
    preg_match_all('#<summary\b.*?</summary>#s', $html, $m);

    return array_map(
        fn (string $summary): string => trim(preg_replace('/\s+/', ' ', strip_tags($summary))),
        $m[0]
    );
}

it('renders FAQ schema questions that match the visible accordion exactly', function () {
    $html = $this->get('/')->assertOk()->getContent();

    $faq = schemaNode(homeJsonLd($html), 'FAQPage');

    $schemaQuestions = array_column($faq['mainEntity'], 'name');

    expect(visibleFaqQuestions($html))->toBe($schemaQuestions);
});

it('renders FAQ schema answers that are present in the page body', function () {
    $html = $this->get('/')->assertOk()->getContent();

    $faq = schemaNode(homeJsonLd($html), 'FAQPage');
    $body = preg_replace('/\s+/', ' ', strip_tags($html));

    foreach ($faq['mainEntity'] as $question) {
        expect($body)->toContain($question['acceptedAnswer']['text']);
    }
});

it('drives both the visible FAQ and its schema from a single config array', function () {
    $html = $this->get('/')->assertOk()->getContent();

    $configured = config('faq.home');

    expect($configured)->not->toBeEmpty()
        ->and(visibleFaqQuestions($html))->toBe(array_column($configured, 'q'));
});

it('publishes no self-serving review markup on the clinic node', function () {
    $html = $this->get('/')->assertOk()->getContent();

    $clinic = schemaNode(homeJsonLd($html), 'Dentist');

    expect($clinic)->not->toHaveKey('aggregateRating')
        ->and($clinic)->not->toHaveKey('review');
});
