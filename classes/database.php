<?php
class database {
    private static $_instance = null ;  
    private $_pdo,
            $_query, 
            $_error  = false, 
            $_results,
            $_count = 0 ;
    private function __construct (){
        try{    
            // establishing pdo connection and storing it in _pdo private proprety 
            $this -> _pdo = new PDO('mysql:host='.config::get('mysql/host').';dbname=' . config::get('mysql/db'), config::get('mysql/username') ,config::get('mysql/password'));
        }catch(PDOexception $e){
            die($e->getMessage());
        }
    }
    // instance to check if already connected to ur database to not connect more than once 
    public static function  getInstance () {
        if ( !isset(self::$_instance) ){
            self::$_instance = new database();
        }
        return self::$_instance;
    }
    // query function that takes the query code as a string and bind it in pdo to prepare it sql code and return object with values 
    public function query( $sql , $params = array() ){
        $this -> _error = false ;
        // checking if the query prepared succesfuly 
        if ($this->_query  = $this->_pdo->prepare($sql)) {
            $x = 1 ;
            if ( count($params) ){
                foreach($params as $param ){
                    $this -> _query->bindValue($x , $param); // assigning each value to the query question mark with indexing each param in array 
                    $x++;
                }
            }
            if ($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }else{
                $this->_error = true ;
            } 
        }
        return $this;
    }
    public function action ($action , $table , $where = array()) {
        if ( count($where) == 3 ){ // means the where must 3 elements the object and operator and value 
            $operators = array ("=",">","<","<=",">=");
            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];
            if ( in_array($operator,$operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? "; // the question mark because where making the query we will bind the value for it 
                if ( !$this->query($sql,array($value))->error() ){ // here where what i mean for binding the value for query if the result is true .. the results object is will be returned 
                    return $this;
                }
            }
        }
        return false;
    }
    public function get ($table,$where) { 
        return $this->action('SELECT *',$table,$where);
    }
    public function delete($table,$where) {
        return $this->action('DELETE',$table,$where);
    }
    public function insert( $table , $fields = array ()){
        $keys = array_keys($fields);
        $values = ' ';
        $x = 1 ; // counter 
        // to create questions marks for binding values to 
        foreach( $fields as $field ){
            $values .= '?' ;
            if ( $x < count($fields) ) {
                $values .=',';
            }
            $x++;
        }
        $sql = "INSERT INTO {$table} (`". implode('`,`' ,  $keys ) ."`) VALUES ({$values})";
        if ( !$this->query($sql,$fields)->error() ){
            return true;
        }
        return false;
    }
    public function update($table , $id , $fields){
        $set = ' ';
        $x = 1 ;
        foreach($fields as $name => $value ){
            $set .="{$name} = ?";
            if ($x < count($fields) ){
                $set .=', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if ( !$this->query($sql,$fields)->error() ){
            return true;
        }
        return false;
    }
    public function results(){
        return $this->_results;
    }
    public function first() {
        return $this->results()[0];
    }
    public function error(){
        return $this->_error;
    }
    public function count(){
        return $this->_count;
    }

}