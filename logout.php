<?php 
require_once 'core/init.php';

$user = new user();
$user->logout();
redirect::to('index.php');