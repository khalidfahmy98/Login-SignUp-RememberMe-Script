<?php 

class redirect {
    public static function to ($location = null ){
        if ( $location ){   
            // now here it comes if the path is for error we will request the error template from includes errors 
            if(is_numeric($location)){ // means comes error number not string 
                switch ($location){
                    case 404:
                        // first include the 404 header error 
                        header('HTTP/1.0 404 Not Found');
                        // second include the 404 template 
                        include 'includes/errors/404.php';
                        exit();
                    break;
                }
            }
            header('Location:' . $location);
            exit();
        }
    }
}