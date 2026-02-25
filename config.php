<?php
// config.php - opensource.xpsystems.eu

$site_config = [
    'site_name'        => 'xpsystems',
    'site_title'       => 'Open Source — xpsystems',
    'site_description' => 'Everything we build, in the open. Explore our repositories, tools, and infrastructure projects at xpsystems.',
    'version'          => 'v1.0.0',
    'current_year'     => date('Y'),
    // Link to this site's own source repo
    'project_github'   => 'https://github.com/xpsystems/opensource',
];

$nav_links = [
    ['label' => 'Home',        'url' => 'https://xpsystems.eu'],
    ['label' => 'Open Source', 'url' => 'https://opensource.xpsystems.eu', 'active' => true],
    ['label' => 'Status',      'url' => 'https://status.xpsystems.eu'],
    ['label' => 'Domains',     'url' => 'https://domains.xpsystems.eu'],
];

// GitHub sources fed into the org-cards section and repo table.
// type "org"  → backend calls /orgs/{handle}/repos
// type "user" → backend calls /users/{handle}/repos
$github_sources = [
    [
        'handle'      => 'xpsystems',
        'type'        => 'org',
        'label'       => 'xpsystems',
        'description' => 'Core infrastructure, tools, and services.',
        'url'         => 'https://github.com/xpsystems',
    ],
    [
        'handle'      => 'xpsystems-ai',
        'type'        => 'user',
        'label'       => 'xpsystems-ai',
        'description' => 'AI-assisted tooling and automation projects.',
        'url'         => 'https://github.com/xpsystems-ai',
    ],
];

$team_members = [
    [
        'name'   => 'Fabian Ternis',
        'github' => 'michaelninder',
        'role'   => 'Co-Founder',
    ],
    [
        'name'   => 'Ramsay Brewer',
        'github' => 'DogWaterDev',
        'role'   => 'Co-Founder',
    ],
];