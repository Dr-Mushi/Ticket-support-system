<?php

class DB {

    private static $instance = null;
    private $pdo,$query,$error = false,$result, $count = 0, $lastInsertID = null;
    
    private function __construct(){
        try{
            $this->pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER ,DB_PASSWORD);
        } catch(PDOException $e){
            exit($e->getMessage());
        }
    }
    public static function getInstance(){
        //use singleton DB to prevent creating more than one connection to the db
        if(!isset(self::$instance)){
            self::$instance = new DB();
        }
        return self::$instance;
    }


    //to use query alone $var->query("SELECT * FROM users);
    public function query($sql,$params = []){
        $this->error = false;
        if($this->query = $this->pdo->prepare($sql)){
            $x = 1;
            if(count($params)){
                foreach($params as $param){
                    $this->query->bindValue($x,$param);
                    $x++;
                }
            }

            if($this->query->execute()){
                $s = "s";
                $this->result = $this->query->fetchAll(PDO::FETCH_OBJ);
                $this->count = $this->query->rowCount();
                $this->lastInsertID = $this->pdo->lastInsertId();
            }else{
                $error = true;
            }
        }
        return $this;
    }


    /* 
        table

        params = [
            'conditions' => "fname = ?",
            'bind' => ['id']
        ]
    
    */
    protected function read($table, $params=[] , $operator = "and"){
        $conditionString = '';
        $bind = [];
        $order = '';
        $limit = '';
        
        // conditions
        if($operator == "and" || $operator == "or"){
            if(isset($params['conditions'])) {
                if(is_array($params['conditions'])) {
                    foreach($params['conditions'] as $condition) {
                        $conditionString .= ' ' . $condition . " $operator";
                    }
                    $conditionString = trim($conditionString);
                    $conditionString = rtrim($conditionString, " $operator");
                } else {
                    $conditionString = $params['conditions'];
                }
                if($conditionString != '') {
                    $conditionString = ' Where ' . $conditionString;
                }
            }
        }
        
        // bind
        if(array_key_exists('bind', $params)) {
            $bind = $params['bind'];
        }
        // order
        if(array_key_exists('order', $params)) {
            $order = ' ORDER BY ' . $params['order'];
        }
         // limit
        if(array_key_exists('limit', $params)) {
            $limit = ' LIMIT ' . $params['limit'];
        }

        $sql = "SELECT * FROM {$table} {$conditionString} {$order} {$limit}";
        if($this->query($sql,$bind)){
            if(!count($this->result)) return false;
            return true;
        }
        return false;
    }

    public function find($table, $params=[],$operator = "and"){
        if($this->read($table, $params,$operator)) {
            return $this->results();
          }
          return false;
    }

    public function findFirst($table, $params=[],$operator = "and"){
        if($this->read($table, $params,$operator)) {
            return $this->first();
        }
        return false;
    }

    /* 
    
        table name
        fields = [
            "fname" => "sultan",
            "lname" => "tarabishi
        ]
    */
    public function insert($table , $fields = []){
        $fieldString = '';
        $valueString = '';
        $values = [];

        foreach($fields as $field => $value){
            $fieldString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
        }

        $fieldString = rtrim($fieldString,',');
        $valueString = rtrim($valueString,',');
        $sql = "INSERT INTO $table ($fieldString) VALUES ($valueString);";
        if(!$this->query($sql,$values)->error()){
            return true;
        }
        return false;
    }

    // table name
    //id number
    /*fields = [
        "fname"=>"sultan",
        "lname"=>"tarabishi"
    ]
    update ($table , $id , $fields);
    */
    public function update($table, $id, $fields = []){
        $fieldString = '';
        $values = [];
        foreach($fields as $field => $value){
            $fieldString .= ' ' . $field . ' = ?,';
            $values[] = $value;
        }
        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString,',');
        $sql = "UPDATE $table SET $fieldString WHERE id = $id";
    
        if(!$this->query($sql,$values)->error()){
            return true;
        }
        return false;
    }
    // delete(table name , and id);
    public function delete($table , $id){
        $sql = "DELETE FROM $table WHERE id = $id";
        if(!$this->query($sql)->error()){
            return true;
        }
        return false;
    }

    //only give you the result values and not the while object
    public function results(){
        return $this->result;
    }

    //find the first value of result
    public function first(){
        return (!empty($this->result)) ? $this->result[0] : [];
    }

    public function count(){
        return $this->count;
    }

    public function lastID(){
        return $this->lastInsertID;
    }

    public function get_columns($table){
        return $this->query("SHOW COLUMNS FROM $table")->results();
    }

    public function error(){
        return $this->error;
    }
}