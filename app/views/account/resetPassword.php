<?= $this->start('body');?>
<form class="form-signin col-lg-4 offset-lg-4" method="POST" action="<?=PROOT?>account/resetPassword">
    <h1 class="h3 mb-3 font-weight-normal">Reset your password</h1>
    <p>An email will be sent to you with instructions on how to reset your password.</p>

    <?php 
         $uMail = "";
        if(isset($_GET['umail'])){
            $uMail = $_GET['umail'];
        }

        if(isset($_GET['error'])){
            $error = $_GET['error'];
             switch($error){
                case "emptyfield":
                    echo '<p class = "text-danger">Fill all fields!!</p>';
                break;
                case "emailnoexist":
                    echo '<p class = "text-danger">This email address doesn\'t exist in our website,
                    check for spelling mistakes or <a href="'.PROOT.'account/register">become a member</a>!</p>';
                break;
                case "notoken":
                    echo '<p class = "text-danger">Password reset link has been expired, Please enter your email address again!';
                break;
                case "emailinvalid":
                    echo '<p class = "text-danger">Invalid email address!</p>';
                break;      
                 default:
                break;
            }
        }
        elseif(isset($_GET['success'])){
            echo '<p class = "text-success">An email has been sent to your email address!</p>';
        }
    ?>





    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Enter your Email address"
        value="<?php echo $uMail;?>">

    <button class="btn btn-lg btn-primary btn-block" type="submit" name="reset-request-submit">Receive new password by
        e-mail</button>


</form>
<?= $this->end();?>