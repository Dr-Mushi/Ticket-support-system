<?php

//to protect from malicous html tags. Like, when you want user to input something 
//in a field and he put a link on that input this way you're no expecting links in input; thus making it as string
//EXAMPLE:
//$str = '<a href="https://www.w3schools.com">Go to w3schools.com</a>'; echo htmlentities($str,ENT_QUOTES);
//OUTPUT
//<a href="https://www.w3schools.com">Go to w3schools.com</a> and not "Go to w3schools.com"

function dnd($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit();
}

function sanitize($dirty){
    return htmlentities($dirty, ENT_QUOTES , 'UTF-8');
}
