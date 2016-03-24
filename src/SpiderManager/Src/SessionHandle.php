<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/3/15
 * Time: PM3:30
 */

namespace SpiderManager\Src;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SessionHandle extends HttpHandle
{
    protected $message;
    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        parent::__construct($config);
    }

    /**
     * @override
     */
    public function CheckUserAgent()
    {
        if ($this->config->has('user_agent') && !empty($this->config->get('user_agent')))
        {
            $this->message = $this->config->get('user_agent');
        }
    }
    /**
     * @override
     */
    public function WriteMessage()
    {
        if (!empty($this->message))
        {
            Session::clear();
            Session::put("http request is search:",$this->message);
            Session::save();
        }
    }
    /**
     * @override
     */
    public function ConfirmMessage()
    {
        if (!empty(Session::get('http request is search:')))
        {
            if ($this->config->get('debug') == true)
            {
                $time  = date("Y-m-d H:i:s",time());
                Log::info($time."__"."http request is search:".$this->config->get('user_agent'));
            }
            return true;
        }
        return false;
    }
}