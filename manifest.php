<?php
if (!defined('FW'))
    die('Forbidden');

$manifest = array();
$manifest['name'] = esc_html__('Deals', 'cannalisting_core');
$manifest['uri'] = 'cannalisting-theme-uri';
$manifest['description'] = esc_html__('This extension will enable the providers to create deals/listings from their dashboard.', 'cannalisting_core');
$manifest['version'] = '1.0.2';
$manifest['author'] = 'cannalisting-theme-author';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['author_uri'] = 'cannalisting-theme-uri';
$manifest['github_repo'] = 'https://github.com/Cannalisting/deals';
$manifest['github_update'] = 'Cannalisting/deals';
$manifest['requirements'] = array(
    'wordpress' => array(
        'min_version' => '4.0',
    )
);

$manifest['thumbnail'] = '/static/img/thumbnails/deals.png';
