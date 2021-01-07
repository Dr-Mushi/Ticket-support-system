
<?= $this->start('body');?>
<form class="form-signin col-lg-4 offset-lg-4" method="POST" action="<?=PROOT?>account/register">
<img class="mb-4" src="<?=PROOT?>/imgs/salad_bowl.jpg" alt=""
            width="120" height="120" >
        <h1 class="h3 mb-3 font-weight-normal">Register</h1>
        <?php
        
        $uName = "";
        $uDisplayName = "";
        $uEmail = "";
        if(isset($_GET['uname'])){
            $uName = $_GET['uname'];
        }
        if(isset($_GET['udisplay'])){
           $uDisplayName = $_GET['udisplay'];
        }
        if(isset($_GET['umail'])){
            $uEmail = $_GET['umail'];
        }
        if(isset($_GET['error'])){
            $error = $_GET['error'];
             switch($error){
                case "emptyfields":
                    echo '<p class = "text-danger">Fill all fields!</p>';
                break;
                case "usernameemailinvalid":
                    echo '<p class = "text-danger">invalid username and email!</p>';
                break;
                case "usernameinvalid":
                    echo '<p class = "text-danger">invalid username!</p>';
                break;
                case "emailinvalid":
                    echo '<p class = "text-danger">invalid email!</p>';
                break;
                case "usernameemailexist":
                    echo '<p class = "text-danger">username and email already exist!</p>';
                break;
                case "usernameexist":
                    echo '<p class = "text-danger">username already exist!</p>';
                break;
                case "emailexist":
                    echo '<p class = "text-danger">email already exist!</p>';
                break;  
                case "passwordnomatch":
                    echo '<p class = "text-danger">Passwrods are not matching!</p>';
                break;
                default:
                break;
             }
         }
         elseif(isset($_GET['success'])){
             echo '<p class = "text-success">Register successful!</p>';
 
         }

        ?>

        <label for="inputUserName" class="sr-only">Username</label>
        <input type="text" id="inputUserName" name="inputUserName" class="form-control" value="<?php echo $uName;?>"
            placeholder="Username" autofocus>

        <label for="inputDisplayName" class="sr-only">Name</label>
        <input type="text" id="inputDisplayName" name="inputDisplayName" class="form-control"
            value="<?php echo $uDisplayName;?>" placeholder="Name">

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text" id="inputEmail" name="inputEmail" class="form-control" value="<?php echo $uEmail;?>"
            placeholder="Email address">

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password">

        <label for="inputRePassword" class="sr-only">Re-enter password</label>
        <input type="password" id="inputRePassword" name="inputRePassword" class="form-control"
            placeholder="Re-enter Password">

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Register</button>
        <p>Already a member? <a href="<?=PROOT?>account/login"> Log in here! </a></p>
    </form>

    

<?= $this->end();?>
