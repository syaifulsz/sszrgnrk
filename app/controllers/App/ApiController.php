<?php

namespace app\controllers\App;

use app\abstracts\ControllerAbstract;
use app\components\RequestComponent;
use app\models\User;

/**
 * Class ApiController
 * @package app\controllers\App
 */
class ApiController extends ControllerAbstract
{
    public function actionIndex( RequestComponent $request )
    {

        return [
            'method' => __METHOD__,
            'request' => $request->toArray(),
            'configs' => $this->configs->toArray()
        ];
    }
}