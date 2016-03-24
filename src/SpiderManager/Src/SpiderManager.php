<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/3/14
 * Time: PM4:32
 */

namespace SpiderManager\Src;

use Exception;

class SpiderManager
{
    /**
     * $app
     */
    protected $app;
    /**
     * $config
     */
    protected $config;
    /**
     * $drivers
     */
    protected $drivers = [];

    public function __construct($app)
    {
        $this->app            = $app;
        $this->config         = new Config($app);
    }

    /**
     *  handle this http request
     *                   -- Auth by Daozi. on 2016.3.15
     */
    public function handle()
    {
        $spiderName  = $this->GetSpiderName();
        if ($spiderName == null || empty($spiderName))
        {
            return;
        }else{
            $Handle  = $this->driver();
            $Handle->handle();
        }
    }

    /**
     * get spiderName
     *             -- Auth by Daozi. on 2016.3.15
     */
    public function GetSpiderName()
    {
        $spiderName       = "";
        $request          = $this->app['request'];
        $user_agent       = $request->header("user-agent");
        $spiderNameArrays = $this->config->get("spiderName");
        if (empty($user_agent) || $user_agent == null)
        {
            return $spiderName;
        }
        if (!empty($spiderNameArrays))
        {
            foreach ($spiderNameArrays as $row)
            {
                if (strpos($user_agent,$row) !== false)
                {
                    $spiderName = $row;
                    $this->config->set('user_agent',$row);
                    break;
                }
            }
        }
        return $spiderName;
    }

    /**
     * Get a driver instance.
     *           -- Auth by Daozi. on 2016.3.17
     */
    private function driver($driver = null)
    {
        $driver = $driver ?: $this->getDefaultDriver();
        if (! isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }
        return $this->drivers[$driver];
    }

    /**
     * Create a new driver instance.
     *           -- Auth by Daozi. on 2016.3.17
     * @param $driver
     * @return
     * @throws Exception
     */
    private function CreateDriver($driver)
    {
        $method = 'create'.ucfirst($driver).'Driver';
        if (method_exists($this,$method))
        {
            return $this->$method();
        }
        throw new Exception("Cant find driver");
    }

    /**
     * Create Session driver instance
     *           -- Auth by Daozi. on 2016.3.17
     */
    protected function createSessionDriver()
    {
        return new SessionHandle($this->config);
    }

    /**
     * Create Databases driver instance
     *          -- Auth by Daozi. on 2016.3.17
     */
    protected function createDatabasesDriver()
    {
        $connection = $this->getDatabaseConnection();
        $table = $this->app['config']['spider.table'];
        return new DatabaseHandle($this->config,$connection,$table);
    }

    /**
     * Get a database connect
     *
     * @return \Illuminate\Database\Connection
     */
    protected function getDatabaseConnection()
    {
        $connection = $this->app['config']['spider.connection'];

        return $this->app['db']->connection($connection);
    }

    /**
     * Get a defaultDriver
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['spider.driver'];
    }
}