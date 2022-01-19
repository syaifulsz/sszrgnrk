<?php

use app\components\ViewComponent;

/**
 * @var $this ViewComponent
 */

?>
<div class="mb-4">
    <div class="display-4 d-flex">
        <span class="text-muted" style="opacity: 0.35;">SSZ</span>
        <span>RGNRK</span>
    </div>
    <div><?= $this->config->app->version ?></div>
</div>