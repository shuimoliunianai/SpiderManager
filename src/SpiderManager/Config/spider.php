<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/3/24
 * Time: AM11:40
 */
return [
    "spiderName"=>[
        "msnbot","Sosospider","Sosoimagespider","Yahoo! Slurp","Googlebot","Googlebot-Image/1.0","Mediapartners-Google","FeedBurner/1.0",
        "Baiduspider","360Spider","YoudaoBot","Speedy Spider","HuaweiSymantecSpider","xFruits","FeedFetcher-Google","YoudaoFeedFetcher"
    ],
    "debug" => true,
    "driver"=>"databases",/**可以是session和数据库*/
    "connection"=>null,
    "table" => "spider_log"
];
