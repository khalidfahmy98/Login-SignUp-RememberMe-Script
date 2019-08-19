<?php
require_once "core/init.php";

if(session::exists('home')){
    echo session::flash('home');
}

$user = new user();

if($user->isLogged()){
?>
    <p>Hello , <?php echo escape( $user->data()->username ); ?> . How are you today ? </p>

    <p> Would you like to visit your <a href="">PROFILE</a> ! </p> 

    <h4>settings</h4>
    <ul>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="updateProfile.php">update</a></li>
        <li><a href="changePassword.php">change password </a></li>
    </ul>
<?php 
}else{
    echo ' You need to <a href="login.php">Login</a>  or <a href="register.php">Regsiter</a> ! ';
}