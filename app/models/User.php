<?php

namespace app\models;

/**
 * Class User
 * @package app\models
 *
 * @property string name
 * @property int age
 */
class User extends Model
{
    public $table = 'users';
    public $timestamps = false;
    public $fillable = [
        'name',
        'age'
    ];
}