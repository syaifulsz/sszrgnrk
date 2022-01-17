<?php

return [
    'appHome'  => [ '/',      [ '\\app\\controllers\\App\\HomeController', 'index' ] ],
    'appAbout' => [ '/about', [ '\\app\\controllers\\App\\AboutController', 'index' ] ],
    'appApi'   => [ '/api',   [ '\\app\\controllers\\App\\ApiController', 'index' ] ],
];