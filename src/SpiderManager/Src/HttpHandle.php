<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/3/15
 * Time: PM3:22
 */

namespace SpiderManager\Src;


use Exceptions;

abstract class HttpHandle
{
    /**
     * 模块儿间的数据传输
     * $config
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }
    /**
     * 检查头信息
     *            -- Auth by Daozi. on 2016.3.15
     */
    public abstract function CheckUserAgent();
    /**
     * 向设备中写入信息
     *           -- Auth by Daozi. on 2016.3.15
     */
    public abstract function WriteMessage();
    /**
     * 确认设备中读信息
     *          -- Auth by Daozi. on 2016.3.15
     */
    public abstract function ConfirmMessage();
    /**
     * 执行逻辑处理
     *          -- Auth by Daozi. on 2016.3.15
     */
    public function handle()
    {
        $this->CheckUserAgent();
        $this->WriteMessage();
        if (!$this->ConfirmMessage())
        {
            throw new ErrorException();
        }else{
            return true;
        }
    }
}