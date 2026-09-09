<?php

return [
    'locale' => 'pt-BR',

    'allowed_statuses' => [
        'pending',
        'approved',
        'rejected',
        'quarantined',
        'expired',
    ],

    'identity_keys' => [
        'id',
        'content_hash',
        'locale',
        'route',
        'context',
    ],

    'required_evidence_fields' => [
        'id',
        'content_hash',
        'locale',
        'route',
        'context',
        'status',
    ],

    'required_inventory_fields' => [
        'id',
        'content',
        'content_hash',
        'locale',
        'route',
        'route_name',
        'context',
        'visibility',
        'source',
    ],

    'scan_roots' => [
        'routes',
        'app/Http/Controllers',
        'config',
        'resources/views',
        'resources/css',
        'resources/js',
        'public',
    ],

    'forbidden_roots' => [
        '.env',
        '.git',
        'vendor',
        'node_modules',
        'storage',
    ],

    'evidence_markers' => [
        'begin' => '<!-- governance-evidence:start -->',
        'end' => '<!-- governance-evidence:end -->',
    ],

    'artifacts' => [
        'inventory' => base_path('.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json'),
        'inventory_report' => base_path('.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.md'),
        'baseline' => base_path('.planning/phases/01-baseline-content-freeze-approval-gates/01-BASELINE.md'),
        'release_gate' => base_path('.planning/phases/01-baseline-content-freeze-approval-gates/01-RELEASE-GATE.md'),
    ],
];
