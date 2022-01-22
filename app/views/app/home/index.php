<?php

use app\components\ViewComponent;

/**
 * @var $this ViewComponent
 */

?>
<div class="mb-3">
    <div><strong>UI Framework</strong></div>
    <ul>
        <li>Bootstrap 5</li>
    </ul>
</div>
<div class="mb-3">
    <div><strong>Components</strong></div>
    <ul>
        <li>Config</li>
        <li>Localization
            <ul>
                <li><span class="text-muted">Code:</span> <?= $this->getLocalization()->default ?></li>
                <li><span class="text-muted">appHome:</span> <?= $this->t( 'appHome' ) ?></li>
            </ul>
        </li>
        <li>Router</li>
        <li>Router Cli</li>
        <li>Route Item</li>
        <li>Str</li>
        <li>Database</li>
        <li>View</li>
        <li>Request</li>
        <li>Request Cli</li>
        <li>Cache
            <ul>
                <li>Memcached</li>
            </ul>
        </li>
    </ul>
</div>
<div class="mb-3">
    <div class=""><strong>rgnrk CLI</strong></div>
    <code>php rgnrk app:setup</code>
</div>
