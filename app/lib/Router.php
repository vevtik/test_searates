<?php

namespace app\lib;

use app\controller\RateController;

class Router
{
    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function run(): string
    {
        $controller = new RateController($this->request);
        $action = 'POST' === $this->request->getMethod() ? 'post' : 'get';

        return call_user_func([$controller, $action]);
    }
}
