<?php 

define('DB_HOST','127.0.0.1'); //database host ** use IP address to avoid DNS lookup
define('DB_NAME','ticket_support'); //database name
define('DB_USER','root'); //database user
define('DB_PASSWORD',''); //database password

define('PROOT','/projects/cs493/ticket_support/'); //set this to '/' for a live server

define('DEFAULT_CONTROLLER','Home'); //default page
define('SITE_TITLE','HelpDesk'); //default title
define('DEFAULT_LAYOUT','default'); //deault page layout


define('FORGOT_PASSWORD_URL','http://localhost/projects/cs493/ticket_support/account/resetPasswordForm');//URL of password reset form

//redirections

//account
define('REGISTER_REDIRECT','Location:'.PROOT.'account'.DS.'register'); //redirect page to register action inside account controller
define('LOGIN_REDIRECT','Location:'.PROOT.'account'.DS.'login');//redirect page to login action inside account controller
define('RESET_PASSWORD_REDIRECT','Location:'.PROOT.'account'.DS.'resetPasswordForm');//redirect page to reset password password form
define('RESET_PASSWORD_EMAIL_REDIRECT','Location:'.PROOT.'account'.DS.'resetPassword');//redirect page to reset password email form

//ticket
define('DASHBOARD_REDIRECT','Location:'.PROOT.'dashboard');
define('NEW_TICKET_REDIRECT','Location:'.PROOT.'requestForm');

//Errors
define('PAGE_NOT_FOUND','Location:'.PROOT.'error'.DS.'error404');//redirect page to error page not found 