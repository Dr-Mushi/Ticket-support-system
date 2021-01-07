<?php

class View{
    protected $head,$body,$siteTitle = SITE_TITLE,$outputBuffer,$layout = DEFAULT_LAYOUT;

    public function __construct(){

    }
    public function render($viewName,$var=[]){
        $viewArray = explode('/',$viewName);
        $viewString = implode(DS,$viewArray);
        if(file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')) {
            include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
            include(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->layout . '.php');
          } else {
            exit('The view \"' . $viewName . '\" does not exist.');
          }
    }

    public function content($type){
        if($type == 'head'){
            return $this->head;
        }
        elseif($type == 'body'){
            return $this->body;
        }
        return false;
    }
    public function start($type){
        $this->outputBuffer = $type;
        ob_start();
    }
    public function end(){
        if($this->outputBuffer == 'head'){
            $this->head = ob_get_clean();
            
        }
        elseif($this->outputBuffer == 'body'){
            $this->body = ob_get_clean();
            
        }else{
            exit('run the start method first!');
        }
    }
    public function setTitle(){
        return $this->siteTitle;
    }

    public function setSiteTitle($title){
        $this->siteTitle = $title;
    }
    public function setLayout($path){
        $this->layout = $path;
    }
}