<?php

class user{

    private $_db,$_data,$_sessionName,$_isLogged,$_cookieName;
    public function __construct($user = null){
        $this->_db = database::getInstance();
        $this->_sessionName = config::get('session/session_name');
        $this->_cookieName = config::get('remember/cookie_name');

        if(!$user){
            if( session::exists($this->_sessionName)){
                $user = session::get($this->_sessionName); // now the user value will be the session of USER  value of ... the value of the session is id of user 
                if($this->find($user)){ // this line will check wither the user id is registered or not .. if its exists by username or id the function will grap all his data in _data prop
                    $this->_isLogged = true ;
                }else{
                    // process logout 
                }
            }
        }else{
            $this->find($user); // to get another user data if that user what u want his data is not logged in  as like this $user = new user(5); ! got it !? 
        }   

    }
    public function create( $fields = array() ){
        if( !$this->_db->insert('users',$fields) ){
            throw new Exception ('there was a problam creating new account');
        }
    }
    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'id' :'username';
            $data = $this->_db->get('users',array($field,'=',$user));
            if($data->count()){
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }
    public function login($username = null  , $password = null , $remember = false  ){

        if ( !$username && !$password && $this->exists() ) { // for automatic login or remember me cookies shitty things  
            session::put($this->_sessionName , $this->data()->id);
        }else{
            $user = $this->find($username);
            if($user){
                if($this->data()->password === hash::make($password,$this->data()->salt)){
                    session::put($this->_sessionName , $this->data()->id);
                    if($remember){
                        $hash = hash::uniqueHash();
                        $hashCheck = $this->_db->get('user_session', array('hash' , '=' , $this->data()->id) );
                        if( !$hashCheck->count() ){
                            $this->_db->insert('user_session',array(
                                'user_id' => $this->data()->id,
                                'hash'    => $hash
                            ));
                        }else{  // notice: we are making this if condition for  making sure that if the user exists in table with old hash value then we will set a new hash value , if the hashcheck is false then we will set a new hash value for him
                            $hash = $hashCheck->first()->hash;
                        }
                        cookie::put($this->_cookieName , $hash , config::get('remember/cookie_expiry'));
                    }
                    return true;
                }
            }
        }
        return false;
    }
    public function update($items = array() , $id = null ){
        if( !$id  && $this->isLogged()){
            $id = $this->data()->id;
        }
        if( !$this->_db->update('users',$id,$items)){
            throw new Exception ("there was a problame while updating information"); 
        }
    }
    public function hasPremission($key){
        // get user groups 
        $group = $this->_db->get('groups',array('id','=',$this->data()->grouping));
        if($group->count()){
            $permissions = json_decode($group->first()->permissions , true); // true for returning an array , false will return an object 
            if($permissions[$key] == true ){
                return true;
            }
        }
        return false;
    }
    public function exists(){
        return (!empty($this->_data)) ? true: false; // becuase checking wiether we got user data or not 
    }
    public function logout(){
        $this->_db->delete('user_session',array('user_id','=',$this->data()->id));
        session::delete($this->_sessionName);
        cookie::delete($this->_cookieName);
    }
    public function data(){
        return $this->_data;
    }
    public function isLogged(){
        return $this->_isLogged;
    }
}