<?php

class HomeController extends Controller{

    public function indexAction(){
        $this->view->render('account/login');
    }

}