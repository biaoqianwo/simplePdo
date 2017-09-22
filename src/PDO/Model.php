<?php
namespace Bee\PDO;

/**
 * Class Model
 * @package Bee\PDO
 */
class Model extends Mysql
{
    public static function config($config)
    {
        parent::getInstance($config);
    }
}
