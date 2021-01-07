<?= $this->start('body');?>
<form class="form-signin col-lg-4 offset-lg-4" method="POST" action="<?=PROOT?>account/resetPasswordForm">
<h1 class="h3 mb-3 font-weight-normal">Reset your password</h1>

<?php
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];
    if(isset($_GET['error'])){
        $error = $_GET['error'];
         switch($error){
            case "emptyfields":
                echo '<p class = "text-danger">Fill all fields!</p>';
            break;
            case "passwordnomatch":
                echo '<p class = "text-danger">Passwrods are not matching!</p>';
            break;   
            default:
            break;
        }
    }

    //check if the selector and validator are empty
    if(empty($selector) || (empty($validator))){
        header(RESET_PASSWORD_EMAIL_REDIRECT . "?error=notoken");
        exit();
    }else{
        //check if the selector and validator are on hexadecimal
        if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
            ?>
            <input type="hidden" name = "selector" value = <?= $selector; ?>>
            <input type="hidden" name = "validator" value = <?= $validator; ?>>

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Enter a new password">

            <label for="inputRePassword" class="sr-only">Re-enter password</label>
            <input type="password" id="inputRePassword" name="inputRePassword" class="form-control"
            placeholder="Reapet new password">
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="reset-request-submit">Reset Password</button>

                    
            </form>

            <?php
        }
    }

?>




<?= $this->end();?>