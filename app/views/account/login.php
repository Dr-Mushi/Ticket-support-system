<?= $this->start('body');?>

<div class="row">


    <form class="form-signin col-lg-4 offset-lg-4 " method="POST" action="<?=PROOT?>account/login">
        <!-- <img class="mb-4" src="<?=PROOT?>/imgs/salad_bowl.jpg" alt="" width="120" height="120"> -->
        <img class="mb-4" src="<?=PROOT?>/imgs/High-Res-YUC-Logo.png" alt="" width="120" height="120"
            class="rounded-circle">
        <h1 class="h3 mb-3 font-weight-normal">log in</h1>
        <?php 
         $uMailName = "";
        if(isset($_GET['unameemail'])){
            $uMailName = $_GET['unameemail'];
        }
        if(isset($_GET['error'])){
            $error = $_GET['error'];
             switch($error){
                case "emptyfields":
                    echo '<p class = "text-danger">Fill all fields!</p>';
                break;
                case "usernotfound":
                    echo '<p class = "text-danger">Username or password is incorrect!</p>';
                break;
                default:
                break;
             }
         }
         elseif(isset($_GET['success'])){
            $success = $_GET['success'];
            switch($success){
                case "login":
                    echo '<p class = "text-success">Login successful!</p>';
                break;
                case "passwordreset":
                    echo '<p class = "text-success">Password reset successful!</p>';
                break;
            }
            
 
         }
    ?>


        <label for="inputUEmailName" class="sr-only">Email address/username</label>
        <input type="text" id="inputUEmailName" class="form-control" name="inputUEmailName"
            value="<?php echo $uMailName;?>" placeholder="Email address/username" autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" name="inputPassword" placeholder="Password">
         <br>

        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Log in</button>
       
    </form>
</div>
<?= $this->end();?>