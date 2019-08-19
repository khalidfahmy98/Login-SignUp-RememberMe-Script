<?php 
// sanitizing the values that is comping from inputs to secure from xss attack . 
function escape($string){
    return htmlentities($string , ENT_QUOTES , 'UTF-8');
}