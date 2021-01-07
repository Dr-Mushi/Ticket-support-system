<?php

class ErrorController extends Controller{
    public function indexAction(){
        $this->view->render('error/error404');
    }

    public function error404Action(){
        $this->view->render('error/error404');
    }
}