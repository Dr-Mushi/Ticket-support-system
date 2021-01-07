<?php


class AccountModel extends Model{

    public function __construct($table){
        parent::__construct($table);
    }

    public function login($sessionName,$id){
        Session::set($sessionName, $id);
    }
    public function register($fields){
        return $this->insert($fields);
    }

    public function logout($sessionName){
        return Session::delete($sessionName);
       
    }

    public function getUser($user){
        $query = $this->findFirst([
            'conditions' => ['user_name = ?'],
            'bind' => ["$user"]
        ]);

        if($query){
            return $query;
        }
        
    }
    public function getDepartments(){
        $query = $this->query("SELECT dep_name FROM departments");

        if($query){
            return $query;
        }
    }

    public function gerDepartment($dep){
        $query = $this->findFirst([
            'conditions' => ['dep_name = ?'],
            'bind' => ["$dep"]
        ]);

        if($query){
            return $query;
        }
    }

    public function getDepartmentID($id){
        $query = $this->findFirst([
            'conditions' => ['id = ?'],
            'bind' => ["$id"]
        ]);

        if($query){
            return $query;
        }
    }

    //delete existing token to avoid having more than one token for one user
    public function deleteToken($uEmail){
        
        $query = $this->findFirst([
            'conditions' => ['pwdResetEmail = ?'],
            'bind' => ["$uEmail"]
        ]);

        //returns boolean
        if($query){
            return $this->delete($query->id);
        }
    }

    //search for token and check if the token is expired
    public function searchPwdToken($selector,$expire){
     
        $query = $this->findFirst([
            'conditions' => ['pwdResetSelector = ?','pwdResetExpires >= ?'],
            'bind' => ["$selector","$expire"]
        ], "and");

        if(!$query){
            $query = $this->findFirst([
                'conditions' => ['pwdResetSelector = ?'],
                'bind' => ["$selector"]
            ], "and");
            $this->deleteToken($query->pwdResetEmail);
            header(RESET_PASSWORD_EMAIL_REDIRECT . "?error=notoken");
            exit();
        }else{
            return $query;
        }
    }
    
    public function updateUserPwd($uEmail,$pwd){

        $query = $this->findFirst([
            'conditions' => ['user_email = ?'],
            'bind' => ["$uEmail"]
        ]);

        
        if(!$query){
            return false;
        }else{
            return $query = $this->update($query->id,[
                'user_pwd' => $pwd
            ]);
        }
        
    }
}