<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/3/15
 * Time: PM3:32
 */

namespace SpiderManager\Src;

use Illuminate\Database\ConnectionInterface;
use Exception;

class DatabaseHandle extends HttpHandle
{
    /**
     * spider_name;
     */
    protected $spiderName;

    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * The name of the spider table.
     *
     * @var string
     */
    protected $table;

    /**
     * The existence state of the spider.
     *
     * @var bool
     */
    protected $exists;

    /**
     * __construct
     * @param Config $config
     * @param ConnectionInterface $connection
     * @param $table
     *                   -- Auth by Daozi. on 2016.3.17
     */
    public function __construct(Config $config ,ConnectionInterface $connection,$table)
    {
        $this->connection = $connection;
        $this->table      = $table;
        parent::__construct($config);
    }

    /**
     * @overrider
     */
    public function CheckUserAgent()
    {
        if ($this->config->has('user_agent') && !empty($this->config->get('user_agent')))
        {
            $this->spiderName = $this->config->get('user_agent');
            $this->read($this->spiderName);
        }else{
            throw new Exception("无效请求头信息");
        }
    }

    /**
     * @override
     */
    public function WriteMessage()
    {
        if ($this->spiderName == "" || $this->spiderName == null)
        {
            return;
        }
        $this->write($this->spiderName);
    }

    /**
     * @override
     */
    public function ConfirmMessage()
    {
        return $this->exists;
    }

    /**
     * {@inheritdoc}
     */
    private function read($spiderName)
    {
        $spider = $this->getQuery()->where("spider_name",$spiderName)->first();
        if (!$spider)
        {
            $this->exists = false;
        }else{
            $this->exists = true;
        }
    }

    /**
     * {@inheritdoc}
     */
    private function write($spiderName)
    {
        if ($this->exists) {
            $this->getQuery()->where('spider_name', $spiderName)->update([
                'day' => date("Ymd",time())
            ]);
            $this->getQuery()->where('spider_name', $spiderName)->increment("count");
        } else {
            $this->getQuery()->insert([
                'spider_name' => $spiderName, 'day'=>date("Ymd",time()), 'count'=>1
            ]);
        }

        $this->exists = true;
    }

    /**
     * {@inheritdoc}
     */
    private function destroy($spiderName)
    {
        $this->getQuery()->where('spider_name', $spiderName)->delete();
    }

    /**
     * Get a fresh query builder instance for the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function getQuery()
    {
        return $this->connection->table($this->table);
    }
}