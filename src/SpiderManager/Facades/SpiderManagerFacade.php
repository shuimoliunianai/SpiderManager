<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/3/14
 * Time: PM4:23
 */

namespace SpiderManager\Facades;


use Illuminate\Support\Facades\Facade;

class SpiderManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SpiderManager';
    }
}