<?php 
    require_once 'core/init.php';

    if( input::exists() ) {
        if(token::check(input::get('token'))){
            $validate = new validation();
            $validate->check($_POST,array(
                'username' => array(
                    'required' => true 
                ),
                'password' => array(
                    'required' => true 
                )
            ));
        if($validate->passed()){
            $user = new user();
            $remember = (input::get('remember') == 'on') ? true : false ;
            $login = $user->login(input::get('username'),input::get('password'),$remember);

            if ($login){
                redirect::to('index.php');
            }else{
                echo 'login failed ';
            }

        }else{
            foreach($validate->errors() as $error ){
                echo $error . '<br>';
            }
        }
    }
}
?>
<form action="" method="post">
    <div class="field">
        <label for="username">username</label>
        <input type="text" id="username" name="username" autocomplete="off">
    </div>
    <div class="field">
        <label for="password">password</label>
        <input type="password" id="password" name="password" autocomplete="off">
    </div>
    <div class="field">
        <input type="checkbox" id="remember" name="remember"  autocomplete="off">
        <label for="remember">remember me</label>
    </div>
    <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
    <input type="submit" autocomplete="off" value="login">
</form>