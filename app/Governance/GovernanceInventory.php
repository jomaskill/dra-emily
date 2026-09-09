<?php

namespace App\Governance;

use Closure;
use DOMDocument;
use DOMNode;
use DOMXPath;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionFunction;
use RuntimeException;
use SplFileInfo;
use Symfony\Component\Process\Process;
use Throwable;

class GovernanceInventory
{
    public const COMMAND_VERSION = '2.0.0';

    /** @var list<string> */
    private const RELEVANT_SOURCE_FILES = [
        'routes/web.php',
        'app/Http/Controllers/ProcedureController.php',
        'app/Http/Controllers/ArticleController.php',
        'config/clinic.php',
        'config/procedures.php',
        'config/articles.php',
        'config/faq.php',
        'resources/css/app.css',
        'resources/js/app.js',
        'public/build/manifest.json',
    ];

    /** @var list<string> */
    private const PUBLIC_ASSET_EXTENSIONS = [
        'avif', 'css', 'gif', 'ico', 'jpeg', 'jpg', 'js', 'png', 'svg', 'webp', 'woff', 'woff2',
    ];

    public function __construct(
        private readonly Router $router,
        private readonly Kernel $kernel,
    ) {}

    /**
     * @return array{
     *     schema_version: int,
     *     decision: string,
     *     run: array{generated_at: string, revision: string, dirty_tree: string, command_version: string, target: string},
     *     summary: array{discovered_items: int, inventoried_items: int, categories: array<string, int>, cardinality: array<string, int>, unresolved_routes: list<string>, errors: list<string>, omissions: list<string>},
     *     items: list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     * }
     */
    public function snapshot(string $target): array
    {
        $scan = $this->scan();

        return [
            'schema_version' => 2,
            'decision' => 'no-change',
            'run' => [
                'generated_at' => now()->format('Y-m-d\TH:i:s.uP'),
                'revision' => $this->gitOutput(['git', 'rev-parse', 'HEAD'], 'unavailable'),
                'dirty_tree' => $this->dirtyTreeDescription(),
                'command_version' => self::COMMAND_VERSION,
                'target' => $this->targetIdentity($target),
            ],
            'summary' => $scan['summary'],
            'items' => $scan['items'],
        ];
    }

    /**
     * Preserve the Plan 01-01 one-item tracer for isolated contract fixtures.
     *
     * @return array{
     *     schema_version: int,
     *     decision: string,
     *     run: array{generated_at: string, revision: string, dirty_tree: string, command_version: string, target: string},
     *     items: list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     * }
     */
    public function tracerSnapshot(string $target): array
    {
        return [
            'schema_version' => 1,
            'decision' => 'no-change',
            'run' => [
                'generated_at' => now()->format('Y-m-d\TH:i:s.uP'),
                'revision' => $this->gitOutput(['git', 'rev-parse', 'HEAD'], 'unavailable'),
                'dirty_tree' => $this->dirtyTreeDescription(),
                'command_version' => self::COMMAND_VERSION,
                'target' => $this->targetIdentity($target),
            ],
            'items' => $this->canonicalizeItems([$this->homepageHeading()]),
        ];
    }

    /**
     * @return array{
     *     summary: array{discovered_items: int, inventoried_items: int, categories: array<string, int>, cardinality: array<string, int>, unresolved_routes: list<string>, errors: list<string>, omissions: list<string>},
     *     items: list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     * }
     */
    public function scan(): array
    {
        $items = [];
        $errors = [];
        $omissions = [];
        $unresolvedRoutes = [];

        foreach ($this->routeTargets($unresolvedRoutes) as $target) {
            try {
                array_push($items, ...$this->inventoryRoute($target));
            } catch (Throwable $exception) {
                $errors[] = sprintf('%s: %s', $target['path'], $this->safeError($exception));
            }
        }

        array_push($items, ...$this->inventoryConfiguredAssertions());
        array_push($items, ...$this->inventorySources());
        array_push($items, ...$this->inventoryPublicAssets());

        $items = $this->canonicalizeItems($items);
        $categories = collect($items)
            ->countBy('category')
            ->sortKeys()
            ->all();

        $cardinality = [
            'procedures' => count(config('procedures', [])),
            'articles' => count(config('articles', [])),
            'faqs' => count(config('faq.home', []))
                + collect(config('procedures', []))->sum(static fn (array $procedure): int => count($procedure['faq'] ?? []))
                + collect(config('articles', []))->sum(static fn (array $article): int => count($article['faq'] ?? [])),
            'media' => (int) ($categories['media'] ?? 0),
            'ctas' => (int) ($categories['conversion'] ?? 0),
            'json_ld' => (int) ($categories['json_ld'] ?? 0),
            'sitemap' => (int) ($categories['sitemap'] ?? 0),
        ];

        foreach ($cardinality as $collection => $count) {
            if ($count === 0) {
                $omissions[] = "Evidência indisponível: the required {$collection} collection contains zero observations.";
            }
        }

        return [
            'summary' => [
                'discovered_items' => count($items),
                'inventoried_items' => count($items),
                'categories' => $categories,
                'cardinality' => $cardinality,
                'unresolved_routes' => $unresolvedRoutes,
                'errors' => $errors,
                'omissions' => $omissions,
            ],
            'items' => $items,
        ];
    }

    /**
     * @param  array<string, mixed>  $inventory
     */
    public function write(string $target, array $inventory): void
    {
        $contents = json_encode(
            $inventory,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
        ).PHP_EOL;

        $this->writeAtomically($target, $contents);
    }

    /**
     * @param  array{run: array<string, mixed>, summary: array<string, mixed>, items: list<array<string, mixed>>}  $inventory
     */
    public function writeReport(string $target, array $inventory): void
    {
        $summary = $inventory['summary'];
        $lines = [
            '# Phase 1 Public Surface Inventory',
            '',
            '- Decision: no-change',
            '- Human approval: not inferred',
            '- Generated at: `'.$inventory['run']['generated_at'].'`',
            '- Revision: `'.$inventory['run']['revision'].'`',
            '- Dirty tree: `'.$inventory['run']['dirty_tree'].'`',
            '- Command version: `'.$inventory['run']['command_version'].'`',
            '- JSON target: `'.$inventory['run']['target'].'`',
            '',
            '## Completeness',
            '',
            '| Measure | Count |',
            '|---|---:|',
            '| Discovered items | '.$summary['discovered_items'].' |',
            '| Inventoried items | '.$summary['inventoried_items'].' |',
        ];

        foreach ($summary['cardinality'] as $collection => $count) {
            $lines[] = '| '.Str::headline($collection).' | '.$count.' |';
        }

        $lines[] = '';
        $lines[] = '## Categories';
        $lines[] = '';
        $lines[] = '| Category | Count |';
        $lines[] = '|---|---:|';

        foreach ($summary['categories'] as $category => $count) {
            $lines[] = '| `'.$category.'` | '.$count.' |';
        }

        $lines[] = '';
        $lines[] = '## Scan Errors and Omissions';
        $lines[] = '';

        if ($summary['errors'] === [] && $summary['omissions'] === [] && $summary['unresolved_routes'] === []) {
            $lines[] = 'None. Inventory completeness does not imply clinical, legal, media, operational, or privacy approval.';
        } else {
            foreach ([...$summary['errors'], ...$summary['omissions'], ...$summary['unresolved_routes']] as $problem) {
                $lines[] = '- '.$problem;
            }
        }

        $lines[] = '';
        $lines[] = '## Freeze Manifest';
        $lines[] = '';
        $lines[] = '| Stable ID | Category | Route | Context | Visibility | Source | SHA-256 |';
        $lines[] = '|---|---|---|---|---|---|---|';

        foreach ($inventory['items'] as $item) {
            $lines[] = sprintf(
                '| `%s` | `%s` | `%s` | `%s` | `%s` | `%s` | `%s` |',
                $item['id'],
                $item['category'],
                $item['route'],
                $item['context'],
                $item['visibility'],
                $item['source'],
                $item['content_hash'],
            );
        }

        $this->writeAtomically($target, implode(PHP_EOL, $lines).PHP_EOL);
    }

    public function writeAtomically(string $target, string $contents): void
    {
        $directory = dirname($target);

        if (! is_dir($directory) || is_link($directory) || is_link($target)) {
            throw new RuntimeException('Inventory target must be in an existing non-symlink directory.');
        }

        $canonicalTarget = (string) realpath($directory).'/'.basename($target);
        $lockPath = sys_get_temp_dir().'/draemily-governance-'.hash('sha256', $canonicalTarget).'.lock';
        $lock = fopen($lockPath, 'c');

        if ($lock === false) {
            throw new RuntimeException('Unable to open the inventory target lock.');
        }

        $temporary = $directory.'/.'.basename($target).'.tmp.'.getmypid().'.'.bin2hex(random_bytes(8));

        try {
            if (! flock($lock, LOCK_EX)) {
                throw new RuntimeException('Unable to acquire the inventory target lock.');
            }

            if (is_link($target)) {
                throw new RuntimeException('Inventory target cannot be a symlink.');
            }

            $temporaryHandle = fopen($temporary, 'x+b');

            if ($temporaryHandle === false) {
                throw new RuntimeException('Unable to create the inventory temporary file.');
            }

            try {
                $this->writeAll($temporaryHandle, $contents);
                fflush($temporaryHandle);

                if (function_exists('fsync')) {
                    fsync($temporaryHandle);
                }
            } finally {
                fclose($temporaryHandle);
            }

            if (! rename($temporary, $target)) {
                throw new RuntimeException('Unable to atomically publish the inventory.');
            }
        } finally {
            if (is_file($temporary)) {
                unlink($temporary);
            }

            flock($lock, LOCK_UN);
            fclose($lock);
        }
    }

    /**
     * @param  list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>  $items
     * @return list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     */
    public function canonicalizeItems(array $items): array
    {
        if ($items === []) {
            throw new RuntimeException('A required public-surface inventory cannot be empty.');
        }

        $this->sortItems($items);
        $this->assertUniqueIdentities($items);

        return $items;
    }

    /**
     * @return array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}
     */
    public function publicationItem(
        string $content,
        string $route,
        string $context,
        string $source,
        string $visibility = 'visible',
        string $routeName = 'home',
        ?string $locale = null,
        string $category = 'visible_text',
    ): array {
        $this->assertSafeSource($source);

        if (! in_array($visibility, ['visible', 'machine_readable', 'both', 'source_only'], true)) {
            throw new RuntimeException('Publication visibility is invalid.');
        }

        $publicationLocale = $locale ?? (string) config('governance.locale', 'pt-BR');
        $stableIdentity = implode("\0", [$publicationLocale, $route, $category, $context, $source]);

        return [
            'id' => 'publication.'.substr(hash('sha256', $stableIdentity), 0, 24),
            'category' => $category,
            'content' => $content,
            'content_hash' => hash('sha256', $content),
            'locale' => $publicationLocale,
            'route' => $route,
            'route_name' => $routeName,
            'context' => $context,
            'visibility' => $visibility,
            'source' => $source,
        ];
    }

    /**
     * @param  list<string>  $unresolvedRoutes
     * @return list<array{path: string, name: string, source: string, expected_status: int}>
     */
    private function routeTargets(array &$unresolvedRoutes): array
    {
        $targets = [];

        foreach ($this->router->getRoutes()->getRoutes() as $route) {
            if (! $this->isPublicGetRoute($route)) {
                continue;
            }

            $routeName = (string) $route->getName();
            $uri = $route->uri();
            $source = $this->routeSource($routeName, null);

            if (! str_contains($uri, '{')) {
                $targets[] = [
                    'path' => '/'.ltrim($uri, '/'),
                    'name' => $routeName,
                    'source' => $source,
                    'expected_status' => 200,
                ];

                continue;
            }

            $values = match ($routeName) {
                'procedure' => array_keys(config('procedures', [])),
                'article' => array_keys(config('articles', [])),
                default => [],
            };

            if ($values === []) {
                $unresolvedRoutes[] = "Unresolved parameterized route: {$routeName} {$uri}";

                continue;
            }

            foreach ($values as $value) {
                $targets[] = [
                    'path' => '/'.ltrim(str_replace('{slug}', $value, $uri), '/'),
                    'name' => $routeName,
                    'source' => $this->routeSource($routeName, $value),
                    'expected_status' => 200,
                ];
            }
        }

        $targets[] = [
            'path' => '/procedimentos/nao-existe',
            'name' => 'procedure.invalid',
            'source' => 'app/Http/Controllers/ProcedureController.php',
            'expected_status' => 404,
        ];
        $targets[] = [
            'path' => '/artigos/nao-existe',
            'name' => 'article.invalid',
            'source' => 'app/Http/Controllers/ArticleController.php',
            'expected_status' => 404,
        ];

        usort($targets, static fn (array $left, array $right): int => [$left['path'], $left['name']] <=> [$right['path'], $right['name']]);

        return $targets;
    }

    private function isPublicGetRoute(Route $route): bool
    {
        if ($route->getName() === null || ! in_array('GET', $route->methods(), true)) {
            return false;
        }

        $action = $route->getAction();

        if (isset($action['view']) && is_string($action['view'])) {
            return true;
        }

        $uses = $action['uses'] ?? null;

        if (is_string($uses)) {
            $controller = ltrim($uses, '\\');

            return str_starts_with($controller, 'App\\')
                || str_starts_with($controller, 'Illuminate\\Routing\\ViewController');
        }

        if ($uses instanceof Closure) {
            $filename = (new ReflectionFunction($uses))->getFileName();

            return is_string($filename)
                && str_starts_with((string) realpath($filename), (string) realpath(base_path('routes')).DIRECTORY_SEPARATOR);
        }

        return false;
    }

    private function routeSource(string $routeName, ?string $slug): string
    {
        return match ($routeName) {
            'home' => 'resources/views/welcome.blade.php',
            'procedure' => ($slug !== null && config("procedures.{$slug}.view") === 'procedures.full-face')
                ? 'resources/views/procedures/full-face.blade.php'
                : 'resources/views/procedure.blade.php',
            'articles.index' => 'resources/views/articles/index.blade.php',
            'article' => 'resources/views/articles/show.blade.php',
            'sitemap' => 'resources/views/sitemap.blade.php',
            default => 'routes/web.php',
        };
    }

    /**
     * @param  array{path: string, name: string, source: string, expected_status: int}  $target
     * @return list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     */
    private function inventoryRoute(array $target): array
    {
        $request = Request::create($target['path'], 'GET');
        $response = $this->kernel->handle($request);

        try {
            $status = $response->getStatusCode();

            if ($status !== $target['expected_status']) {
                throw new RuntimeException("Expected HTTP {$target['expected_status']} but observed {$status}.");
            }

            $items = [
                $this->publicationItem(
                    (string) $status,
                    $target['path'],
                    'route:http-status',
                    $target['source'],
                    'machine_readable',
                    $target['name'],
                    category: 'route',
                ),
                $this->publicationItem(
                    (string) $response->headers->get('Content-Type', ''),
                    $target['path'],
                    'route:content-type',
                    $target['source'],
                    'machine_readable',
                    $target['name'],
                    category: 'metadata',
                ),
            ];

            if ($status === 404) {
                return $items;
            }

            $content = (string) $response->getContent();

            if ($target['name'] === 'sitemap') {
                array_push($items, ...$this->inventorySitemap($content, $target));
            } else {
                array_push($items, ...$this->inventoryHtml($content, $target));
            }

            return $items;
        } finally {
            $this->kernel->terminate($request, $response);
        }
    }

    /**
     * @return array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}
     */
    private function homepageHeading(): array
    {
        $request = Request::create('/', 'GET');
        $response = $this->kernel->handle($request);

        try {
            if (! $response->isSuccessful()) {
                throw new RuntimeException('The named homepage route could not be rendered.');
            }

            $document = $this->loadHtml((string) $response->getContent(), '/');
            $heading = (new DOMXPath($document))->query('//main//h1')?->item(0);

            if ($heading === null || $heading->textContent === '') {
                throw new RuntimeException('The homepage has no main heading publication item.');
            }

            return $this->publicationItem(
                $heading->textContent,
                '/',
                'visible:main:h1',
                'resources/views/welcome.blade.php',
            );
        } finally {
            $this->kernel->terminate($request, $response);
        }
    }

    /**
     * @param  array{path: string, name: string, source: string, expected_status: int}  $target
     * @return list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     */
    private function inventoryHtml(string $html, array $target): array
    {
        $document = $this->loadHtml($html, $target['path']);
        $xpath = new DOMXPath($document);
        $items = [];

        foreach ($this->nodes($xpath, '//head/title | //head/meta[@content] | //head/link[@rel="canonical"]') as $index => $node) {
            $name = $node->nodeName === 'title'
                ? 'title'
                : ($node->attributes?->getNamedItem('name')?->nodeValue
                    ?? $node->attributes?->getNamedItem('property')?->nodeValue
                    ?? 'canonical');
            $value = $node->nodeName === 'title'
                ? $this->visibleText($node->textContent)
                : ($node->attributes?->getNamedItem('content')?->nodeValue
                    ?? $node->attributes?->getNamedItem('href')?->nodeValue
                    ?? '');

            if ($value !== '') {
                $items[] = $this->publicationItem($value, $target['path'], "metadata:{$name}:{$index}", $target['source'], 'machine_readable', $target['name'], category: 'metadata');
            }
        }

        foreach ($this->nodes($xpath, '//main//h1 | //main//h2 | //main//h3 | //main//p | //main//li | //main//summary | //main//figcaption | //main//a | //main//button | //footer//p | //footer//a | //nav//a') as $index => $node) {
            $text = $this->visibleText($node->textContent);

            if ($text !== '') {
                $items[] = $this->publicationItem($text, $target['path'], 'visible:'.$node->nodeName.':'.$index, $target['source'], 'visible', $target['name'], category: 'visible_text');
            }
        }

        foreach ($this->nodes($xpath, '//a[@href]') as $index => $node) {
            $destination = $this->sanitizeDestination((string) $node->attributes?->getNamedItem('href')?->nodeValue);
            $category = $this->isConversionDestination($destination) ? 'conversion' : 'link';
            $context = $category.':a['.$index.']:href';

            $items[] = $this->publicationItem($destination, $target['path'], $context, $target['source'], 'visible', $target['name'], category: $category);
        }

        foreach ($this->nodes($xpath, '//img[@src] | //source[@srcset]') as $index => $node) {
            $value = (string) ($node->attributes?->getNamedItem('src')?->nodeValue ?? $node->attributes?->getNamedItem('srcset')?->nodeValue ?? '');
            $alt = (string) ($node->attributes?->getNamedItem('alt')?->nodeValue ?? '');
            $content = json_encode(['source' => $value, 'alt' => $alt], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

            $items[] = $this->publicationItem($content, $target['path'], 'media:'.$node->nodeName.':'.$index, $target['source'], 'visible', $target['name'], category: 'media');
        }

        foreach ($this->nodes($xpath, '//script[@type="application/ld+json"]') as $scriptIndex => $node) {
            try {
                $decoded = json_decode($node->textContent, true, flags: JSON_THROW_ON_ERROR);
            } catch (Throwable $exception) {
                throw new RuntimeException("JSON-LD block {$scriptIndex} is invalid: ".$this->safeError($exception));
            }

            foreach ($this->flattenValues($decoded) as $pointer => $value) {
                $items[] = $this->publicationItem($value, $target['path'], "json-ld:{$scriptIndex}:{$pointer}", $target['source'], 'machine_readable', $target['name'], category: 'json_ld');
            }
        }

        foreach ($this->nodes($xpath, '//script[contains(@src,"googletagmanager") or contains(text(),"gtag(")]') as $index => $node) {
            $content = (string) ($node->attributes?->getNamedItem('src')?->nodeValue ?? $this->visibleText($node->textContent));
            $items[] = $this->publicationItem($this->sanitizeDestination($content), $target['path'], "analytics:script:{$index}", $target['source'], 'machine_readable', $target['name'], category: 'analytics');
        }

        return $items;
    }

    /**
     * @param  array{path: string, name: string, source: string, expected_status: int}  $target
     * @return list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     */
    private function inventorySitemap(string $xml, array $target): array
    {
        $previousErrors = libxml_use_internal_errors(true);

        try {
            $document = new DOMDocument('1.0', 'UTF-8');

            if (! $document->loadXML($xml, LIBXML_NONET)) {
                throw new RuntimeException('Sitemap response is not parseable XML.');
            }

            $items = [];
            $xpath = new DOMXPath($document);

            foreach ($this->nodes($xpath, '//*[not(*)]') as $index => $node) {
                $value = $this->visibleText($node->textContent);

                if ($value !== '') {
                    $items[] = $this->publicationItem($value, $target['path'], 'sitemap:'.$node->localName.':'.$index, $target['source'], 'machine_readable', $target['name'], category: 'sitemap');
                }
            }

            return $items;
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previousErrors);
        }
    }

    /**
     * @return list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     */
    private function inventoryConfiguredAssertions(): array
    {
        $items = [];

        foreach ([
            'clinic' => config('clinic', []),
            'faq' => config('faq', []),
            'procedures' => config('procedures', []),
            'articles' => config('articles', []),
        ] as $configName => $values) {
            foreach ($this->flattenValues($values) as $pointer => $value) {
                $route = $this->configRoute($configName, $pointer);
                $routeName = $this->configRouteName($configName);
                $items[] = $this->publicationItem(
                    $value,
                    $route,
                    "configured:{$configName}:{$pointer}",
                    "config/{$configName}.php",
                    'source_only',
                    $routeName,
                    category: 'configured_assertion',
                );
            }
        }

        return $items;
    }

    private function configRoute(string $configName, string $pointer): string
    {
        $firstSegment = explode('/', ltrim($pointer, '/'))[0] ?? '';

        return match ($configName) {
            'procedures' => '/procedimentos/'.$firstSegment,
            'articles' => '/artigos/'.$firstSegment,
            default => '/',
        };
    }

    private function configRouteName(string $configName): string
    {
        return match ($configName) {
            'procedures' => 'procedure',
            'articles' => 'article',
            default => 'home',
        };
    }

    /**
     * @return list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     */
    private function inventorySources(): array
    {
        $sources = self::RELEVANT_SOURCE_FILES;

        $views = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(resource_path('views'), RecursiveDirectoryIterator::SKIP_DOTS),
        );

        foreach ($views as $view) {
            if ($view instanceof SplFileInfo && $view->isFile() && ! $view->isLink() && $view->getExtension() === 'php') {
                $sources[] = $this->relativePath($view->getPathname());
            }
        }

        $items = [];

        foreach (array_values(array_unique($sources)) as $source) {
            $absolutePath = base_path($source);

            if (! is_file($absolutePath) || is_link($absolutePath)) {
                continue;
            }

            $contentHash = hash_file('sha256', $absolutePath);

            if ($contentHash === false) {
                throw new RuntimeException("Unable to hash source {$source}.");
            }

            $descriptor = json_encode([
                'path' => $source,
                'sha256' => $contentHash,
                'bytes' => filesize($absolutePath),
            ], JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

            $items[] = $this->publicationItem($descriptor, '@source', 'source:file:'.$source, $source, 'source_only', 'source', category: 'source');
        }

        return $items;
    }

    /**
     * @return list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     */
    private function inventoryPublicAssets(): array
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(public_path(), RecursiveDirectoryIterator::SKIP_DOTS),
        );
        $items = [];

        foreach ($iterator as $file) {
            if (! $file instanceof SplFileInfo || ! $file->isFile() || $file->isLink()) {
                continue;
            }

            $extension = Str::lower($file->getExtension());

            if (! in_array($extension, self::PUBLIC_ASSET_EXTENSIONS, true)) {
                continue;
            }

            $source = $this->relativePath($file->getPathname());
            $fileHash = hash_file('sha256', $file->getPathname());

            if ($fileHash === false) {
                throw new RuntimeException("Unable to hash public asset {$source}.");
            }

            $descriptor = [
                'path' => $source,
                'sha256' => $fileHash,
                'bytes' => $file->getSize(),
            ];
            $dimensions = @getimagesize($file->getPathname());

            if (is_array($dimensions)) {
                $descriptor['width'] = $dimensions[0];
                $descriptor['height'] = $dimensions[1];
            }

            $items[] = $this->publicationItem(
                json_encode($descriptor, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
                '@asset',
                'public-asset:file:'.$source,
                $source,
                'source_only',
                'asset',
                category: 'public_asset',
            );
        }

        return $items;
    }

    private function loadHtml(string $html, string $route): DOMDocument
    {
        $previousErrors = libxml_use_internal_errors(true);

        try {
            $document = new DOMDocument('1.0', 'UTF-8');

            if (! $document->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING)) {
                throw new RuntimeException("Route {$route} returned unparseable HTML.");
            }

            return $document;
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previousErrors);
        }
    }

    /** @return list<DOMNode> */
    private function nodes(DOMXPath $xpath, string $query): array
    {
        $nodeList = $xpath->query($query);

        if ($nodeList === false) {
            throw new RuntimeException('Unable to evaluate a public-surface DOM query.');
        }

        return iterator_to_array($nodeList);
    }

    /**
     * @return array<string, string>
     */
    private function flattenValues(mixed $value, string $pointer = ''): array
    {
        if (! is_array($value)) {
            return [$pointer === '' ? '/' : $pointer => $this->scalarValue($value)];
        }

        $flattened = [];

        foreach ($value as $key => $child) {
            $escapedKey = str_replace(['~', '/'], ['~0', '~1'], (string) $key);
            $childPointer = $pointer.'/'.$escapedKey;
            $flattened += $this->flattenValues($child, $childPointer);
        }

        return $flattened;
    }

    private function scalarValue(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        return json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }

    private function visibleText(string $value): string
    {
        return Str::squish($value);
    }

    private function isConversionDestination(string $destination): bool
    {
        return Str::contains(Str::lower($destination), ['wa.me/', 'whatsapp.com/', 'api.whatsapp.com/']);
    }

    private function sanitizeDestination(string $destination): string
    {
        if (! Str::contains($destination, '?')) {
            return $destination;
        }

        $parts = parse_url($destination);

        if ($parts === false || ! isset($parts['query'])) {
            return $destination;
        }

        parse_str($parts['query'], $query);

        foreach ($query as $key => $value) {
            if (preg_match('/token|secret|password|email|patient|cpf|session|code/i', (string) $key) === 1) {
                $query[$key] = '[redacted]';
            }
        }

        $base = '';

        if (isset($parts['scheme'])) {
            $base .= $parts['scheme'].'://';
        }

        $base .= $parts['host'] ?? '';
        $base .= $parts['path'] ?? '';
        $base .= '?'.http_build_query($query, encoding_type: PHP_QUERY_RFC3986);

        if (isset($parts['fragment'])) {
            $base .= '#'.$parts['fragment'];
        }

        return $base;
    }

    private function dirtyTreeDescription(): string
    {
        $status = $this->gitOutput(['git', 'status', '--porcelain=v1', '--untracked-files=all'], 'unavailable');

        if ($status === 'unavailable') {
            return $status;
        }

        if ($status === '') {
            return 'clean';
        }

        return sprintf(
            'dirty:sha256=%s;entries=%d',
            hash('sha256', $status),
            substr_count($status, "\n") + 1,
        );
    }

    private function targetIdentity(string $target): string
    {
        $base = rtrim(base_path(), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $normalized = str_replace('\\', '/', $target);
        $normalizedBase = str_replace('\\', '/', $base);

        if (str_starts_with($normalized, $normalizedBase)) {
            return Str::after($normalized, $normalizedBase);
        }

        return 'external:'.basename($target);
    }

    private function relativePath(string $path): string
    {
        $base = rtrim(str_replace('\\', '/', base_path()), '/').'/';
        $normalized = str_replace('\\', '/', $path);

        if (! str_starts_with($normalized, $base)) {
            throw new RuntimeException('Scanned source is outside the repository root.');
        }

        return Str::after($normalized, $base);
    }

    private function safeError(Throwable $exception): string
    {
        return class_basename($exception).' during restricted public-surface scan';
    }

    /**
     * @param  list<array{id: string, content_hash: string, route: string, context: string}>  $items
     */
    private function sortItems(array &$items): void
    {
        usort($items, static function (array $left, array $right): int {
            foreach (['id', 'route', 'context', 'content_hash'] as $key) {
                $comparison = strcmp($left[$key], $right[$key]);

                if ($comparison !== 0) {
                    return $comparison;
                }
            }

            return 0;
        });
    }

    /**
     * @param  list<array{id: string}>  $items
     */
    private function assertUniqueIdentities(array $items): void
    {
        $identities = [];

        foreach ($items as $item) {
            if (isset($identities[$item['id']])) {
                throw new RuntimeException('Duplicate publication identity detected.');
            }

            $identities[$item['id']] = true;
        }
    }

    private function assertSafeSource(string $source): void
    {
        if ($source === '' || str_starts_with($source, '/') || str_contains($source, '\\')) {
            throw new RuntimeException('Publication source must be a repository-relative POSIX path.');
        }

        $segments = explode('/', $source);

        if (in_array('..', $segments, true) || in_array('', $segments, true)) {
            throw new RuntimeException('Publication source cannot escape an allowed scan root.');
        }

        /** @var list<string> $forbiddenRoots */
        $forbiddenRoots = config('governance.forbidden_roots', []);

        foreach ($forbiddenRoots as $forbiddenRoot) {
            if ($source === $forbiddenRoot || str_starts_with($source, $forbiddenRoot.'/')) {
                throw new RuntimeException('Publication source is inside a forbidden root.');
            }
        }

        $absoluteSource = base_path($source);
        $realSource = realpath($absoluteSource);

        if ($realSource === false || is_link($absoluteSource)) {
            throw new RuntimeException('Publication source must be an existing non-symlink path.');
        }

        /** @var list<string> $scanRoots */
        $scanRoots = config('governance.scan_roots', []);
        $insideAllowedRoot = false;

        foreach ($scanRoots as $scanRoot) {
            $realRoot = realpath(base_path($scanRoot));

            if ($realRoot !== false && ($realSource === $realRoot || str_starts_with($realSource, $realRoot.DIRECTORY_SEPARATOR))) {
                $insideAllowedRoot = true;

                break;
            }
        }

        if (! $insideAllowedRoot) {
            throw new RuntimeException('Publication source is outside the allowed scan roots.');
        }
    }

    /**
     * @param  list<string>  $command
     * @param  callable(string): string|null  $transform
     */
    private function gitOutput(array $command, string $fallback, ?callable $transform = null): string
    {
        try {
            $process = new Process($command, base_path());
            $process->run();

            if (! $process->isSuccessful()) {
                return $fallback;
            }

            $output = rtrim($process->getOutput());

            return $transform === null ? $output : $transform($output);
        } catch (Throwable) {
            return $fallback;
        }
    }

    /** @param resource $handle */
    private function writeAll($handle, string $contents): void
    {
        $offset = 0;
        $length = strlen($contents);

        while ($offset < $length) {
            $written = fwrite($handle, substr($contents, $offset));

            if ($written === false || $written === 0) {
                throw new RuntimeException('Unable to write the complete inventory payload.');
            }

            $offset += $written;
        }
    }
}
