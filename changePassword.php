<?php 
    require_once 'core/init.php';
    $user = new user();
    if($user->isLogged()){
        if( input::exists() ) {
            if(token::check(input::get('token'))){
                $validate = new validation();
                $validate->check($_POST,array(
                    'current_password' => array (
                        'required' => true ,
                        'min' => 6 
                    ),
                    'New_password' => array(
                        'required' => true ,
                        'min' => 6 

                    ),
                    'Confirm_password' => array(
                        'required' => true ,
                        'min' => 6 ,
                        'matches' => 'New_password'
                    )
                ));

                if($validate -> passed()){
                    if(hash::make(input::get('current_password'),$user->data()->salt) !== $user->data()->password ){ // creating a hash 
                        echo 'Incorrect Current Password';
                    }else{
                        $salt = hash::salt(32);
                        $hashedPassword = hash::make(input::get('New_password'),$salt);
                        $user->update(array(
                            'password'=>$hashedPassword,
                            'salt' => $salt
                        ));

                        session::flash('home','Your password is changes now ');
                        redirect::to('index.php');
                    }
                }else{
                    foreach($validate->errors() as $error){
                        echo $error .'<br>';
                    }
                }
            }
        }
?>
<form action="" method="post">
    <div class="field">
        <label for="current_password">Current Password </label>
        <input type="password" name="current_password" id="current_password" autocomplete="off">
    </div>
    <div class="field">
        <label for="New_password">New Password </label>
        <input type="password" name="New_password" id="New_password" autocomplete="off">
    </div>
    <div class="field">
        <label for="Confirm_password">Confirm New Password </label>
        <input type="password" name="Confirm_password" id="Confirm_password" autocomplete="off">
    </div>

    <div class="field">
        <input type="hidden" value="<?php echo token::generate()?>" name="token">
        <input type="submit" value="changePass">
    </div>
</form>
<?php 
}else{
    redirect::to('login.php');
}