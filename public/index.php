<?php

require __DIR__ . '/../vendor/autoload.php';

use app\App;

$app = new App( [
    'root_dir'   => realpath( __DIR__ . '/..' ),
    'app_dir'    => realpath( __DIR__ . '/../app' ),
    'public_dir' => __DIR__,
    'config_dir' => realpath( __DIR__ . '/../app/configs' ),
    'view_dir'   => realpath( __DIR__ . '/../app/views' ),
    'app_env'    => getenv( 'SITE_ENV' ),
] );
$app->run();