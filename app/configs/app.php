<?php

$version = file_get_contents( __DIR__ . '/../../VERSION.md' );

return [
    'name' => 'SSZRGNRK',
    'baseUrl' => 'http://sszrgnrk.local',
    'version' => $version
];