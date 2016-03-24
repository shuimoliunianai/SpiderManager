<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/3/14
 * Time: PM4:20
 */

namespace SpiderManager\Providers;



use Illuminate\Support\ServiceProvider;
use SpiderManager\Console\SpiderTableCommand;
use SpiderManager\Src\SpiderManager;

class SpiderManagerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Config/spider.php' => config_path('spider.php')
        ], 'config');
    }
    /**
     *
     *  注册服务提供者
     *                   -- Auth by Daozi. on 2016.3.15
     */
    public function register()
    {
        $this->registerSpiderManager();
        $this->registerCommandProvider();
    }
    /**
     * 注册蜘蛛管理器
     *                   -- Auth by Daozi. on 2016.3.15
     */
    private function registerSpiderManager()
    {
        $this->app->singleton('SpiderManager',function($app)
        {
            return new SpiderManager($app);
        });
    }
    /**
     * 注册command命令
     *                    -- Auth by Daozi. on 2016.3.16
     */
    private function registerCommandProvider()
    {
        $this->app->singleton('command.spider.database', function ($app) {
            return new SpiderTableCommand($app['files'], $app['composer']);
        });
        $this->commands('command.spider.database');
    }
}