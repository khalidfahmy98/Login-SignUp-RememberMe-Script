<?php 
    require_once 'core/init.php';
    if(!$username = input::get('user')){
        redirect::to('index.php');
    }else{
        // checking if the exists based on user class constructor 
        $user = new user($username);
        if(!$user->exists()){
            redirect::to(404);
        }else{
            echo 'exists';
        }
    }