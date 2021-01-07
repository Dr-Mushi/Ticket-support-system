<?= $this->start('body');?>


<?php
if(!$_SESSION['userName']){
    //put error header here
    header(LOGIN_REDIRECT);
}

//print_r($_SESSION['userName']);

if(extract($var)){
    
     
}



?>


<form class="form-signin col-lg-4 offset-lg-4" method="POST" action="<?=PROOT?>requestForm">
    <!-- <img class="mb-4" src="<?=PROOT?>/imgs/salad_bowl.jpg" alt="" width="120" height="120"> -->
    <img class="mb-4" src="<?=PROOT?>/imgs/YUC_Icon.png" alt="" width="420" height="150">

    <p>
        <a href="<?=PROOT?>dashboard">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
            </svg>
            Back to dashboard
        </a>
    </p>
    <h1 class="h3 mb-3 font-weight-normal">New ticket</h1>

    <?php

        $subject = "";
        $statement = "";
        if(isset($_GET['subject'])){
            $subject = $_GET['subject'];

        }
        if(isset($_GET['statement'])){
            $statement = $_GET['statement'];
        }

        
        if(isset($_GET['error'])){
            $error = $_GET['error'];
            switch($error){
                case "emptyfields":
                    echo '<p class = "text-danger">Fill all fields!</p>';
                break;

                case "maximumExceed":
                    echo '<p class = "text-danger">Write a title that is under 40 characters!</p>';
                default:
                break;
            }
        }
    ?>

    <label for="inputTitle" class="sr-only">Request title</label>
    <input type="text" id="inputTitle" name="inputTitle" class="form-control" value = "<?=$subject?>" placeholder="title"
        placeholder="Request title" autofocus>
    <br>
    <label for="inputStatement" class="sr-only">Problem statement</label>
    <textarea id="inputStatement" name="inputStatement" class="form-control z-depth-1" placeholder="Problem statement"
        rows="10"><?=$statement?></textarea>
    <br>
    <!-- <select class="form-control" name="inputDepartement" id="inputDepartement">
        <?php
            if(!empty($deps)){  
                print_r($deps);
                foreach($deps as $dep){
        ?>
        <option value="<?=$dep->dep_name?>"><?=$dep->dep_name?></option>
        <?php
                }
            }
        ?>
    </select> -->

    <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">SEND REQUEST</button>

</form>



<?= $this->end();?>