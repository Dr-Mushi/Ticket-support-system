<?php


class Controller{
    protected $controller,$action;
    public $view;
    public function __construct($controller,$action){
        $this->controller = $controller;
        $this->action = $action;
        $this->view = new View();
    }
}