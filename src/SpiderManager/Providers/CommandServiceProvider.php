<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/3/14
 * Time: PM4:50
 */

namespace SpiderManager\Providers;


use Illuminate\Support\ServiceProvider;
use SpiderManager\Console\SpiderTableCommand;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * 主要用于注册artisan命令生成记录爬虫的数据库
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.session.database', function ($app) {
            return new SpiderTableCommand($app['files'], $app['composer']);
        });

        $this->commands('command.session.database');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.spider.database'];
    }
}