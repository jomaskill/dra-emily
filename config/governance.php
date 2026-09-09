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

    'release_categories' => [
        'claims' => [
            'requirement' => 'GOV-03',
            'owner' => 'Dra. Emily and named content owner',
            'file' => '01-CLAIMS.md',
            'research_fields' => ['owner', 'evidence_system', 'validity_period', 'exact_release_binding'],
        ],
        'media' => [
            'requirement' => 'GOV-04',
            'owner' => 'Authorized media custodian',
            'file' => '01-MEDIA.md',
            'research_fields' => ['owner', 'evidence_system', 'validity_period', 'classification', 'exact_release_binding'],
        ],
        'professional_wording' => [
            'requirement' => 'GOV-05',
            'owner' => 'CRO-MG or qualified counsel',
            'file' => '01-PROFESSIONAL-WORDING.md',
            'research_fields' => ['owner', 'evidence_system', 'validity_period', 'scope_applicability', 'exact_release_binding'],
        ],
        'operations' => [
            'requirement' => 'GOV-06',
            'owner' => 'Clinic operations verifier',
            'file' => '01-OPERATIONS.md',
            'research_fields' => ['owner', 'evidence_system', 'validity_period', 'observed_facts', 'exact_release_binding'],
        ],
        'privacy' => [
            'requirement' => 'MEAS-03',
            'owner' => 'Named privacy owner',
            'file' => '01-PRIVACY-DECISION.md',
            'research_fields' => ['owner', 'evidence_system', 'validity_period', 'deployed_analytics_state', 'exact_release_binding'],
        ],
    ],

    'required_inventory_collections' => [
        'procedures',
        'articles',
        'faqs',
        'media',
        'ctas',
        'json_ld',
        'sitemap',
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
