<?php

class Router{

    public static function route($url){
        //controller
        //will take the first element off the url and uppercase the first letter
        //http://localhost/projects/Personal/Salad%20Maker/Project_testing/users output is Users
        $controller = (isset($url[0]) && $url[0] != "") ? ucwords($url[0]).'Controller': DEFAULT_CONTROLLER.'Controller';
        //remove the first element of the array by shifting the array.
        //http://localhost/projects/Personal/Salad%20Maker/Project_testing/users/s output is s
        array_shift($url);
        
        
        //action
        $action = (isset($url[0]) && $url[0] != "") ? $url[0] . 'Action': 'indexAction';
        array_shift($url);

        //params
        $queryParams = $url;

        if(class_exists($controller)){
            $dispatch = new $controller($controller,$action);
        }else{
            $dispatch = "";
            //change this to error type display
            header(PAGE_NOT_FOUND);
        }

        if(method_exists($dispatch ,$action)){
            call_user_func_array([$dispatch,$action],$queryParams);
        }else{
            //change this to error type display
            exit('that method doesn\'t exist in the controller \\'.$controller . '\\');
        }
    }

}