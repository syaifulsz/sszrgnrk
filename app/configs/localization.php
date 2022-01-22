<?php

$localizations = [
    'default' => 'en'
];

foreach ( glob( __DIR__ . '/localization/*.php' ) as $f ) {
    $info = pathinfo( $f );
    $localizations[ $info[ 'filename' ] ] = require $f;
}
return $localizations;