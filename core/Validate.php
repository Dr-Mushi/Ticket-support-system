<?php


class Validate extends Model{

    private $uName = "";
    private $uEmail = "";
    private $uDisplayName = "";
    private $mailName = "";

    //call model with the table name to access database operations through model class
    public function __construct($table){
        parent::__construct($table);
    }

    /////////////////////////////////////LOGIN/////////////////////////////////////

    //get the infromation of the user using username or email
    public function getEmailAndUserName($uName,$uEmail){
        $query = $this->findFirst([
            'conditions' => ["user_name = ?", "user_email = ?"],
            'bind' => [$uName , $uEmail]
        ],"or");
        if(!$query){
            header(LOGIN_REDIRECT . "?error=usernotfound&unameemail=" . $uName);
            exit();
        }
        $this->$mailName = $uName;
        return $query;
    }
   
    //check for empty fields in login form
    public function emptyCheckLogin($uMailName,$uPwd){
        //check if the username and password are empty.
        if(empty($uMailName) || empty($uPwd)){
            header(LOGIN_REDIRECT . "?error=emptyfields&unameemail=" . $uMailName);
            exit();
        }
        return true;
    }

    //check for if password is matching and username exists
    public function userCheckLogin($username,$uPwd){
        //check if the passwords match
        //after using encryption use the password verify
        if(/* !password_verify($uPwd,$username->user_pwd) */ !$this->passwordMatch($uPwd ,$username->user_pwd) ){
            header(LOGIN_REDIRECT . "?error=usernotfound&unameemail=" . $this->$mailName);
            exit();
        }else{
            return true;
        }
    }

    /////////////////////////////////////REGISTER/////////////////////////////////////
    //check for empty fields in register form
    public function emptyCheckRegister($uName,$uDisplayName,$uEmail,$uPwd,$reUPwd){
        if(empty($uName) || empty($uDisplayName) || empty($uEmail) || empty($uPwd)|| empty($reUPwd)){
            header(REGISTER_REDIRECT . "?error=emptyfields&uname=" . $uName . "&udisplay=" . $uDisplayName . "&umail=" . $uEmail);
            exit();    
        }
        $this->uName = $uName;
        $this->uDisplayName = $uDisplayName;
        $this->uEmail = $uEmail;
        return true;
    }

    //check if user or email exist NEED UPGRADING TO RETURN BOOLEAN INSTEAD OF REDIRECTING TO SAVE WRITING FUNCTIONS
    public function userEmailCheck($uName,$uEmail){
        
        $username = [
            'conditions' => ['user_name = ?'],
            'bind' => ["$uName"]
        ];
        $email = [
            'conditions' => ['user_email = ?'],
            'bind' => ["$uEmail"]
        ];
        if($this->findFirst($username,$operator = "and") && $this->findFirst($email,$operator = "and")){
            header(REGISTER_REDIRECT . "?error=usernameemailexist&uname=" . $this->uName . "&udisplay=" . $this->uDisplayName . "&umail=" . $this->uEmail);
            exit(); 
        }
        elseif($this->findFirst($username,$operator = "and")){
            header(REGISTER_REDIRECT . "?error=usernameexist&uname=" . $this->uName . "&udisplay=" . $this->uDisplayName . "&umail=" . $this->uEmail);
            exit(); 
        }
        elseif($this->findFirst($email,$operator = "and")){
            header(REGISTER_REDIRECT . "?error=emailexist&uname=" . $this->uName . "&udisplay=" . $this->uDisplayName . "&umail=" . $this->uEmail);
            exit(); 
        }
        return true;
    }

    //check if email exists in reset password NEED UPGRADING TO RETURN BOOLEAN INSTEAD OF REDIRECTING TO SAVE WRITING FUNCTIONS
    public function emailCheck($uEmail){
        $email = [
            'conditions' => ['user_email = ?'],
            'bind' => ["$uEmail"]
        ];

        if($this->findFirst($email,$operator = "and")){
            return true; 
        }
        return false;
    }

    
    //check if the input is within a-z A-Z and 0-9
    private function userNameValidate($uName){
        //Search Pattern
        if(preg_match("/^[a-zA-Z0-9]*$/",$uName)){
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }
    //check if email is valid
    public function emailValidate($uEmail){
        if(filter_var($uEmail,FILTER_VALIDATE_EMAIL)){
            $result = true;
        }else{
            $result = false;
        }
        //return boolean
        return $result;
    }

    //validate user and email input
    public function emailUserValidate($uName,$uEmail){
        if($this->emailValidate($uEmail) === false && $this->userNameValidate($uName) === false){
            header(REGISTER_REDIRECT . "?error=usernameemailinvalid&uname=" . $this->uName .  "&umail=" . $this->uEmail . "&udisplay=" . $this->uDisplayName);
            exit();  
        }
        elseif($this->userNameValidate($uName) === false){
            header(REGISTER_REDIRECT . "?error=usernameinvalid&uname=" . $this->uName .  "&umail=" . $this->uEmail . "&udisplay=" . $this->uDisplayName);
            exit();  
        }
        elseif($this->emailValidate($uEmail) === false){
            header(REGISTER_REDIRECT . "?error=emailinvalid&uname=" . $this->uName .  "&umail=" . $this->uEmail . "&udisplay=" . $this->uDisplayName);
            exit();
        }
        return true;
    }
    //check password and re-password if they are matching
    public function passwordMatch($uPwd,$reUPwd){
        if(strcmp($uPwd,$reUPwd) !== 0){
            return false;
        }
        return true;
    }
}