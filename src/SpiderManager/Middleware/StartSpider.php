<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/3/15
 * Time: PM5:40
 */

namespace SpiderManager\Middleware;


use Closure;
use SpiderManager\Src\SpiderManager;

class StartSpider
{
    /**
     * 蜘蛛记录管理器
     *
     * @var \Illuminate\Session\SessionManager
     */
    protected $manager;

    /**
     * @param SpiderManager $manager
     */
    public function __construct()
    {
        $provider = app()->getBindings();
        if (array_key_exists("SpiderManager",$provider))
        {
            $this->manager = app("SpiderManager");
        }else{
            $this->manager = null;
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->startSpiderManager($request);
        $response = $next($request);

        return $response;
    }

    /**
     * @param $request
     */
    public function startSpiderManager($request)
    {
        if ($this->manager == null)
        {
            return;
        }else{
            $this->manager->handle($request);
            return;
        }
    }
    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {

    }

}