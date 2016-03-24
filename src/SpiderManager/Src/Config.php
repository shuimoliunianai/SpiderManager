<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/3/15
 * Time: PM3:46
 */

namespace SpiderManager\Src;

class Config extends Collect
{
    /**
     * 该模块儿的配置文件
     *                 -- Auth by Daozi. on 2016.3.15
     */
    public function __construct($items)
    {
        $option     = array();
        if (isset($items['config']['spider']))
        {
            $option = $items['config']['spider'];

        }
        parent::__construct($option);
    }
}