<?php 
    require_once 'core/init.php';
    if( input::exists() ) {
        if(token::check(input::get('token'))){
            $validate = new validation();
            $validate->check($_POST,array(
                'username' => array(
                    'required' => true ,
                    'min'   => 2,
                    'max'   => 20,
                    'unique' => 'users'
                ),
                'password' => array(
                    'required' => true ,
                    'min'   => 6
                ),
                'confirm-password' => array(
                    'required' => true ,
                    'matches' => 'password'
                ),
                'Name' => array(
                    'required' => true ,
                    'min'   => 2,
                    'max'   => 50,
                )
            ));
            if($validate->passed()){
                $user = new user();
                $salt = hash::salt(32);
                try{
                    $user->create(array( // keys of this array represent the columns name in the table of the database 
                        'username' => input::get('username'),
                        'password' => hash::make(input::get('password'),$salt),
                        'salt' => $salt,
                        'name' => input::get('Name'),
                        'joined' => date('Y-m-d H:i:s'),
                        'grouping' => 1
                    ));
                    session::flash('home','you are successfuly registered login now ! ');
                    redirect::to('index.php');
                }catch (Exception $e){
                    die($e->getMessage());
                }
            }else{
                print_r($validate->errors());
            }
        }
    }
?>
<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(input::get('username'));?>" autocomplete="off">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password"  autocomplete="off">
    </div>
    <div class="field">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" name="confirm-password" id="confirm-password"  autocomplete="off">
    </div>
    <div class="field">
        <label for="Name">Name</label>
        <input type="text" name="Name" id="Name" value="<?php echo escape(input::get('Name'));?>" autocomplete="off">
    </div>
    <div class="field">
        <input type="hidden"  name="token" value="<?php echo token::generate(); ?>" >
        <input type="submit"  value="Register">
    </div>
</form>