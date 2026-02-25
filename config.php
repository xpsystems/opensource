<?php
// config.php - opensource.xpsystems.eu

$site_config = [
    'site_name'        => 'xpsystems',
    'site_title'       => 'Open Source — xpsystems',
    'site_description' => 'Everything we build, in the open. Explore our repositories, tools, and infrastructure projects at xpsystems.',
    'version'          => 'v1.0.0',
    'current_year'     => date('Y'),
];

$nav_links = [
    ['label' => 'Home',        'url' => 'https://xpsystems.eu'],
    ['label' => 'Open Source', 'url' => 'https://opensource.xpsystems.eu', 'active' => true],
    ['label' => 'Status',      'url' => 'https://status.xpsystems.eu'],
    ['label' => 'Domains',     'url' => 'https://domains.xpsystems.eu'],
];

$footer_links = [
    ['label' => 'Impressum', 'url' => 'https://xpsystems.eu/impressum'],
    ['label' => 'Privacy',   'url' => 'https://xpsystems.eu/privacy'],
];

$github_orgs = [
    [
        'handle'      => 'xpsystems',
        'label'       => 'xpsystems',
        'description' => 'Core infrastructure, tools, and services.',
        'url'         => 'https://github.com/xpsystems',
        'color'       => 'accent',
    ],
    [
        'handle'      => 'xpsystems-ai',
        'label'       => 'xpsystems-ai',
        'description' => 'AI-assisted tooling and automation projects.',
        'url'         => 'https://github.com/xpsystems-ai',
        'color'       => 'purple',
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
?>