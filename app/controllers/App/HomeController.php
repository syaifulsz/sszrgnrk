<?php

namespace app\controllers\App;

use app\abstracts\ControllerAbstract;
use app\components\RequestComponent;

/**
 * Class HomeController
 * @package app\controllers\App
 */
class HomeController extends ControllerAbstract
{
    public function actionIndex( RequestComponent $request )
    {
        return $this->renderAction();
    }
}