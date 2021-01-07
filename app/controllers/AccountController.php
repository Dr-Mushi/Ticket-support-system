<?php
session_start();

class AccountController extends Controller{

    public function indexAction(){
        $this->loginAction();
    }

    public function RegisterAction(){
        if(isset($_POST["register"])){
            //take all fields from view/account/register.view.php
            $uName = $_POST['inputUserName'];
            $uDisplayName = $_POST['inputDisplayName'];
            $uEmail = $_POST['inputEmail'];
            $uPwd = $_POST['inputPassword'];
            $reUPwd  = $_POST['inputRePassword'];

            //account variable to access login and register methods
            $account = new AccountModel("users");
            //validation to get the user information after validating them
            $validate = new Validate("users");
            
            
           
            /*
            check for empty fields, then check if the username and email are valid, then check if the 
            username and email already exists in the database, then match the passwords
            and create new user after hashing the password.
             */
            if($validate->emptyCheckRegister($uName,$uDisplayName,$uEmail,$uPwd,$reUPwd)){
                if($validate->emailUserValidate($uName,$uEmail)){
                    if($validate->userEmailCheck($uName,$uEmail)){
                        if(!$validate->passwordMatch($uPwd,$reUPwd)){
                            header(REGISTER_REDIRECT . "?error=passwordnomatch&uname=" . $uName . "&udisplay=" . $uDisplayName . "&umail=" . $uEmail);
                            exit();
                        }else{
                            $hashedUPwd = password_hash($uPwd,PASSWORD_DEFAULT);
                            $account->register([
                                "user_name" => $uName,
                                "user_dp_name"=> $uDisplayName,
                                "user_email"=>$uEmail,
                                "user_pwd"=>$hashedUPwd
                            ]);
                            header(REGISTER_REDIRECT . "?success=register");
                        }
                    }
                }
            }
        }else{
            //if nothing is POSTed then render register page
            $this->view->render('account/register');
        }
    }
    public function loginAction(){
        if(isset($_POST['login'])){
            $uMailName = $_POST['inputUEmailName'];
            $uPwd = $_POST['inputPassword'];

            //account variable to access login and register methods
            $account = new AccountModel("users");
            //validation to get the user information after validating them
            $validate = new Validate("users");

           
            
            //check if the username and password are empty.
            if($validate->emptyCheckLogin($uMailName,$uPwd)){
                //check if email or username are being input RETURNS USER OBJECT.
                $username = $validate->getEmailAndUserName($uMailName,$uMailName);
                //check if the username and password are correct
                if($validate->userCheckLogin($username,$uPwd)){
                    //create new session for user
                    $account->login("userId",$username->id);
                    $account->login("userName",$username->user_name);
                    $account->login("userType",$username->user_type);
                    $account->login("userDep",$username->user_dp_name);
                    /* $account->login("password",$username->user_pwd); */
                    header(DASHBOARD_REDIRECT . "?success=login");
                    exit();
                }
            }

        }else{
            //if nothing is POSTed then render login page
            $this->view->render('account/login');
        }
    }

    //form where user enter email
    public function resetPasswordAction(){
        if(isset($_POST['reset-request-submit'])){

            $uEmail = $_POST['inputEmail'];

            $validate = new Validate("users");

            //check if input is empty
            if(empty($uEmail)){
                header(RESET_PASSWORD_EMAIL_REDIRECT . "?error=emptyfield");
                exit();
            }

            //check if the email is valid
            if($validate->emailValidate($uEmail) === false){
                header(RESET_PASSWORD_EMAIL_REDIRECT . "?error=emailinvalid");
                exit();
            }
            //check if the email exist in the user db
            if($validate->emailCheck($uEmail) === false){
                header(RESET_PASSWORD_EMAIL_REDIRECT . "?error=emailnoexist&umail=". $uEmail);
                exit();
            }

            //selector to select from database
            $selector = bin2hex(random_bytes(8));
            //token to validate the proper user after selecting user
            $token = random_bytes(32);

            //url to send 
            $url = FORGOT_PASSWORD_URL ."?selector=". $selector . "&validator=". bin2hex($token);

            //date start since 1970 in seconds, 900 = 15 mins
            $expires = date("U") + 900;

            //create new accountmodel to access deleteToken
            $account = new AccountModel("pwdreset");


            //delete token to avoid having more than one token of the same user
            $account->deleteToken($uEmail);
            
            //hash the token first
            $hashedToken = password_hash($token,PASSWORD_DEFAULT);
            //insert new token
            $account->register([
                "pwdResetEmail" => $uEmail,
                "pwdResetSelector"=> $selector,
                "pwdResetToken"=>$hashedToken,
                "pwdResetExpires"=>$expires
            ]);

            //PHPMailer class
            $mailer = new Mailer();

            $subject = 'Password Reset for Salad Maker';

            $body = '<p>We recieved a password reset request. The link to your password is below.
             IF you didn\'t make this request, you can ignore this email. </p>';
            $body .= '<p>Here is your password reset link:<br>';
            $body .= '<a href= "' . $url .  '" >' . $url . '</a></p>';

            $fromEmail = "tarabishi-999@windowslive.com";
            $fromName = "Salad Maker";

            $toEmail = $uEmail;
            $toName = "Sultan";

            $mailer->PrepareEmail();
            $mailer->emailHeader($fromEmail,$fromName, $toEmail , $toName);
            $mailer->emailContent($subject,$body);
            $mailer->sendEmail();

            header(RESET_PASSWORD_EMAIL_REDIRECT.'?success=email');
            
        }else{
            $this->view->render('account/resetPassword');
        }
    }

    //Form where user can enter new password
    public function resetPasswordFormAction(){
        
        if(isset($_POST['reset-request-submit'])){
            
            $selector = $_POST['selector'];
            $validator = $_POST['validator'];
            $uPwd = $_POST['inputPassword'];
            $reUPwd  = $_POST['inputRePassword'];


            //validation to get the user information after validating them
            $validate = new Validate("users"); 
            
            //check if password fields are empty
            if(empty($uPwd) || empty($reUPwd) ){
                header(RESET_PASSWORD_REDIRECT . "?error=emptyfields&selector=". $selector . "&validator=" . $validator);
                exit();
            }
            //check if password input match
            elseif(!$validate->passwordMatch($uPwd,$reUPwd)){
                header(RESET_PASSWORD_REDIRECT . "?error=passwordnomatch&selector=". $selector . "&validator=" . $validator);
                exit();
            }

            $currentDate = date("U");

            $accountUsers = new AccountModel("users");
           
            $accountToken = new AccountModel("pwdreset");


            //search for token and check if the token is expired
            $query = $accountToken->searchPwdToken($selector,$currentDate);
            
            
            //return to binary to verify tokens
            $tokenbin = hex2bin($validator);

            //check if the token inisde db is the same as the post method
            $tokenCheck = password_verify($tokenbin,$query->pwdResetToken);

            if($tokenCheck === false){
                header(RESET_PASSWORD_EMAIL_REDIRECT . "?error=notoken");
                exit();
            }elseif($tokenCheck === true){
                //hash the new password and update the user table
                $hashedPwd = password_hash($uPwd,PASSWORD_DEFAULT);
                if($accountUsers->updateUserPwd($query->pwdResetEmail,$hashedPwd)){
                    //delete the token after finishing proccess and redirect to login page
                    $accountToken->deleteToken($query->pwdResetEmail);
                    header(LOGIN_REDIRECT . "?success=passwordreset");
                    exit();
                }else{
                    //delete token if the email is not found in the user table and reditect to email form page
                    $accountToken->deleteToken($query->pwdResetEmail);
                    header(RESET_PASSWORD_EMAIL_REDIRECT . "?error=emailnoexist");
                    exit();
                };
            }
        }else{
            $this->view->render('account/resetPasswordForm');
        }
    }

    public function logoutAction(){
        $accountUsers = new AccountModel("users");
        $userName = $accountUsers->logout('userName');
        $userType = $accountUsers->logout('userType');
        if($userName){
            header(LOGIN_REDIRECT."?sucess=logout");
        }else{
            header(LOGIN_REDIRECT."?error=logout");
        }
        
        
    }
}