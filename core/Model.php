<?php

class Model{
    protected $db,$table,$softDelete = false;

    public function __construct($table){
        $this->db = DB::getInstance();
        $this->table = $table;
    }
    
    public function insert($fields){
        if(empty($fields)) return false;
        return $this->db->insert($this->table,$fields);
    }

    public function update($id,$fields){
        if(empty($fields) || $id == '') return false;
        return $this->db->update($this->table,$id,$fields);
    }

    public function delete($id =''){
        if($id == '' && $this->id == '') return false;
        $id = ($id == '') ? $this->id : $id;
        if($this->softDelete){
            return $this->update($id, ['deleted' => 1]);
        }
        return $this->db->delete($this->table,$id);
    }

    public function find($params = [],$operator = "and"){
        return $this->db->find($this->table, $params,$operator);
    }

    public function findFirst($params = [],$operator = "and"){
        return $this->db->findFirst($this->table, $params,$operator);
    }
    public function query($sql,$bind =[]){
        return $this->db->query($sql,$bind)->results();
    }
}