<?php
    require_once 'core/init.php';
    $user = new user();
    if($user->isLogged()){
        $userId = session::get(config::get('session/session_name'));
        if( input::exists() ) {
            if(token::check(input::get('token'))){
                $validate = new validation();
                $validate -> check($_POST,array(
                    'fullname' => array(
                        'required' => true,
                        'min' => 2,
                        'max'=> 50
                    )
                ));
                if($validate->passed()){
                    try{
                        $user->update(array(
                            'name' => input::get('fullname')
                        ));
                        session::flash('home','Your Details Has Been Updated');
                        redirect::to('index.php');
                    }catch(Exception $e){
                        die($e->getMessage());
                    }
                }else{
                    foreach($validate->errors() as $error ){
                        echo $error .'<br>';
                    }
                }
            }
        }
        ?>
        <h1>Hey There , <?php echo $user->data()->username; ?>  </h1>
        <p>Now Kindly You Can Update Your Information Easily</p>
        <form action="" method="POST">
            <div class="field">
                <label for="fullname">Full Name </label>
                <input type="text" value="<?php echo $user->data()->name; ?>" id="fullname" name="fullname" autocomplete="off">
            </div>
            <div class="field">
                <input type="hidden" value="<?php echo token::generate();?>" name="token">
                <input type="submit"   value="updateProf">
            </div>
        </form>
        <?php 
    }else{
        redirect::to('logout.php');
    }
