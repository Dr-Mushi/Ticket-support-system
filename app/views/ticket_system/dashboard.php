<?= $this->start('body');?>

<?php
if(!$_SESSION['userName']){
    //put error header here
    header(LOGIN_REDIRECT);
}

if(extract($var)){

}


if(!empty($posts)){
    if($_SESSION['userType'] === "employee"){
        $priorityTemp = false;
        $depTemp = false;
        $statTemp = false;
        $userTemp = false;
        $priorityArray = array("unassigned");
        $depArray = array("unassigned");
        $statArray = array("unassigned");
        $userArray = array("unassigned");
        $priorityOptions = "";
        $depOptions = "";
        $statOptions = "";
        $userOptions = "";
        foreach($posts as $post){
            //get priority 
            foreach($priority as $prior){
                if($prior->priority === $post->priority){
                    $priorityTemp[$post->id] = true;
                    $prioritySelected = 'selected = "selected"';
                }else{
                    $prioritySelected = '';
                }
                $priorityOptions .= '<option value="'.$prior->id.'" '.$prioritySelected.'>'.$prior->priority.'</option>';
            }
            $priorityArray =  array_push_assoc($priorityArray, $post->id, $priorityOptions); 
            $priorityOptions="";

            //get departments
            foreach($department as $dep){
                if($dep->dep_name === $post->dep_name){
                    $depTemp[$post->id] = true;
                    $depSelected = 'selected = "selected"';
                }else{
                    $depSelected = '';
                }
                $depOptions .= '<option value="'.$dep->id.'" '.$depSelected.'>'.$dep->dep_name.'</option>';
            }
            $depArray=  array_push_assoc($depArray, $post->id, $depOptions); 
            $depOptions = "";

            //get status
            foreach($status as $stat){
                if($stat->status === $post->status){
                    $statTemp[$post->id] = true;
                    $statSelected = 'selected = "selected"';
                }else{
                    $statSelected = '';
                }
                $statOptions .= '<option value="'.$stat->id.'" '.$statSelected.'>'.$stat->status.'</option>';
            }
            $statArray=  array_push_assoc($statArray, $post->id, $statOptions); 
            $statOptions = "";

            //get user
            foreach($users as $user){
                
                if($user->user_name === $post->assigned_to){
                    $userTemp[$post->id] = true;
                    $userSelected = 'selected = "selected"';
                }else{
                    $userSelected = '';
                }
                    $userOptions .= '<option value="'.$user->id.'" '.$userSelected.'>'.$user->user_name.'</option>';
            }
            
            $userArray=  array_push_assoc($userArray, $post->id, $userOptions); 
            $userOptions = "";
        }
    
    }
}


function array_push_assoc(&$array, $key, $value){
    $array[$key] = $value;
    return $array;
}



//what will employees see
if($_SESSION['userType'] === "employee"){
?>


<header>
    <p hidden id="serverResponse"></p>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <img class="mb-4" src="<?=PROOT?>/imgs/High-Res-YUC-Logo.png" alt="" width="100" height="80"
            class="rounded-circle">
        <!-- <img src="<?=PROOT?>/imgs/salad_bowl.jpg" width="40" height="40" class="rounded-circle"> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a href="<?=PROOT?>dashboard/index/userid" class="nav-link">Department requests</a>
                </li>
                <li class="nav-item">
                    <a href="<?=PROOT?>dashboard/myRequests/userid" class="nav-link">My Requests</a>
                </li>

                <li class="nav-item">
                    <a href="<?=PROOT?>dashboard/history/userid" class="nav-link">History</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <a href="<?=PROOT?>requestForm" class="nav-link"><button class="btn btn-primary">New
                        Ticket</button></a>
                <li class="nav-item active">

                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg width="3em" height="2.5em" viewBox="0 0 16 16" class="bi bi-file-person-fill"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm-3 4c2.623 0 4.146.826 5 1.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-1.245C3.854 11.825 5.377 11 8 11z" />
                        </svg>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <p class="dropdown-item">
                            <svg width="3em" height="2.5em" viewBox="0 0 16 16" class="bi bi-file-person-fill"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm-3 4c2.623 0 4.146.826 5 1.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-1.245C3.854 11.825 5.377 11 8 11z" />
                            </svg>
                            <?=$_SESSION["userName"]?>
                        </p>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=PROOT?>dashboard/index/userid">Department requests</a>
                        <a class="dropdown-item" href="<?=PROOT?>dashboard/myRequests/userid">My requests</a>
                        <a class="dropdown-item" href="<?=PROOT?>dashboard/history/userid">History</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=PROOT?>account/logout">Log Out</a>
                    </div>
                </li>
                <li>
                    <form class="form-inline my-2 my-lg-0" method="POST" action="<?=PROOT?>dashboard/search">
                        <input class="form-control" style="color:green" type="search" name="search" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"
                            name="searchDashboard">Search</button>
                    </form>
                </li>

            </ul>
        </div>
    </nav>
</header>


<div>
    <table id="table" class="table">
        <thead class="table-primary">
            <th>ID</th>
            <th>Subject</th>
            <th>Requester</th>
            <th>Assigned</th>
            <th>Priority</th>
            <th>Assigned Department</th>
            <th>Status</th>
            <th>Creation Date</th>
        </thead>
        <tbody class="table-danger">
            <?php
                if(!empty($posts)){
                foreach($posts as $post){
            ?>
            <tr>
                <td id=""><?=$post->id?></td>
                <!-- max characters would be 40 -->
                <td><a href="<?=PROOT?>ticket/request/<?=$post->id?>"><?=$post->subject?></a></td>

                <td>

                    <?=$post->requester?>

                </td>
                <td>
                    <select name="<?=$post->id?>" id="user" onchange="update(this,'assigned_to')"
                        class="custom-select custom-select-sm">
                        <option value=""><?=
                       $userTemp === false ? $userArray[0].$userArray[$post->id] : $userArray[0].$userArray[$post->id];
                        ?></option>

                    </select>
                </td>
                <td>
                    <select name="<?=$post->id?>" id="" onchange="update(this,'priority')"
                        class="custom-select custom-select-sm">
                        <?=
                        $priorityArray === false ? $priorityArray[0].$priorityArray[$post->id] : $priorityArray[$post->id];
                        ?>
                    </select>
                </td>
                <td>
                    <select name="<?=$post->id?>" id="" onchange="update(this,'assigned_dep')"
                        class="custom-select custom-select-sm">
                        <?=
                        $depArray === false ? $depArray[0].$depArray[$post->id] : $depArray[$post->id];
                        ?>
                    </select>
                </td>
                <td>
                    <!-- <select name="<?=$post->id?>" id="" onchange="update(this,'status')"
                        class="custom-select custom-select-sm">
                        <?=
                        $statTemp === false ? $statArray[0].$statArray[$post->id] : $statArray[$post->id]; 
                        ?>
                    </select> -->
                    <?=
                        $post->status;
                    ?>
                </td>
                <td><?=$post->creation_date?></td>
            </tr>
            <?php
                }
            }else{
                echo "<tr>
                        <td  colspan = 8>No requests</td>
                    </tr>
                ";
            }
            ?>
        </tbody>
    </table>
</div>


<script type="text/javascript">
/* AJAX SCRIPT */
function update(a, type) {
    var id = a.name;
    var value = a.value;
    if (a.value == "") {
        value = "NULL";
    }

    console.log(a.value);
    const xhr = new XMLHttpRequest();
    xhr.onload = function() {
        const serverResponse = document.getElementById("serverResponse");
        serverResponse.innerHTML = this.responseText;
        //refresh part of html page
        $('#table').load(document.URL + ' #table');

    }
    xhr.open("POST", "<?=PROOT?>dashboard/ajax/" + type);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    /* console.log("value of a "+value); */
    xhr.send(type + "=" + value + "&ticket=" + id);

}
</script>


<?php 
//what will requesters see
}elseif($_SESSION['userType'] === "requester"){
?>


<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <img class="mb-4" src="<?=PROOT?>/imgs/High-Res-YUC-Logo.png" alt="" width="100" height="80"
            class="rounded-circle">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a href="<?=PROOT?>dashboard/index/userid" class="nav-link">Pending requests</a>
                </li>
                <li class="nav-item">
                    <a href="<?=PROOT?>dashboard/history/userid" class="nav-link">Resolved requests</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <a href="<?=PROOT?>requestForm" class="nav-link"><button class="btn btn-primary">New
                        Ticket</button></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg width="3em" height="2.5em" viewBox="0 0 16 16" class="bi bi-file-person-fill"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm-3 4c2.623 0 4.146.826 5 1.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-1.245C3.854 11.825 5.377 11 8 11z" />
                        </svg>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <p class="dropdown-item">
                            <svg width="3em" height="2.5em" viewBox="0 0 16 16" class="bi bi-file-person-fill"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm-3 4c2.623 0 4.146.826 5 1.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-1.245C3.854 11.825 5.377 11 8 11z" />
                            </svg>
                            <?=$_SESSION["userName"]?>
                        </p>
                        <a class="dropdown-item" href="<?=PROOT?>dashboard/index/userid">Pending requests</a>
                        <a class="dropdown-item" href="<?=PROOT?>dashboard/history/userid">Resolved requests</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=PROOT?>account/logout">Log Out</a>
                    </div>
                </li>
                <li>
                    <form class="form-inline my-2 my-lg-0" method="POST" action="<?=PROOT?>dashboard/search">
                        <input class="form-control" style="color:green" type="search" name="search" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"
                            name="searchDashboard">Search</button>
                    </form>
                </li>

            </ul>
        </div>
    </nav>
</header>


<div>
    <table class="table">
        <thead class="table-primary">
            <th>ID</th>
            <th>Subject</th>
            <th>Requester</th>
            <th>Assigned</th>
            <th>Priority</th>
            <th>Assigned Department</th>
            <th>Status</th>
            <th>Creation Date</th>
        </thead>
        <tbody class="table-danger">
            <?php
                if(!empty($posts)){
                foreach($posts as $post){
            ?>
            <tr>
                <td><?=$post->id?></td>
                <!-- max characters would be 40 -->
                <td><a href="<?=PROOT?>ticket/request/<?=$post->id?>"><?=$post->subject?></a></td>

                <td>

                    <?=$post->requester?>

                </td>
                <td>

                    <option value=""><?=$post->assigned_to === NULL ? "Unassigned" : $post->assigned_to?>

                </td>
                <td>

                    <?=$post->priority?>

                </td>
                <td>

                    <?=$post->dep_name?>
                </td>
                <td>

                    <?=$post->status?>

                </td>
                <td><?=$post->creation_date?></td>
            </tr>
            <?php
                }
            }else{
                echo "<tr>
                        <td  colspan = 8>No requests</td>
                    </tr>
                ";
            }
            ?>
        </tbody>
    </table>
</div>


<?php }?>


<?= $this->end();?>