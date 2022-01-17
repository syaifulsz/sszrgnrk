<?php

namespace app\models\Secondary;

use app\models\Model;
use app\services\Database\DatabaseSecondaryService;

/**
 * Class User
 * @package app\models\Secondary
 */
class User extends Model
{
    public $connection = DatabaseSecondaryService::CONNECTION_NAME;
    public $table = 'users';
}