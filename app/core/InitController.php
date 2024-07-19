<?php

namespace app\core;

class InitController
{
    public $view;
    public $route;
    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
    }
    public function render($view, $params=[])
    {
        $this->view->render($view,$params);
    }

    public function redirect($url)
    {
        $this->view->redirect($url);
    }
    public function behaviors(){
        return[];
    }
}