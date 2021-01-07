<?= $this->start('body');?>


<?php


if(!$_SESSION['userName']){
    //put error header here
    header(LOGIN_REDIRECT . "?error=loginagain");
}


if(extract($var)){
    //print_r($posts);
    if(empty($posts)){
        header(PAGE_NOT_FOUND);
    }
    if($_SESSION['userType'] === "employee"){
        $priorityTemp = false;
        $depTemp = false;
        $statTemp = false;
        $priorityArray = array("unassigned");
        $depArray = array("unassigned");
        $statArray = array("unassigned");
        $priorityOptions = "";
        $depOptions = "";
        $statOptions = "";
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

        }
    
    }
}
function array_push_assoc(&$array, $key, $value){
    $array[$key] = $value;
    return $array;
}
 
?>
<?php
if($_SESSION['userType'] === "employee"){
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
                <li class="nav-item active">
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
                        <a class="dropdown-item" href="<?=PROOT?>dashboard/index/userid">Department requests</a>
                        <a class="dropdown-item" href="<?=PROOT?>dashboard/myRequests/userid">My Requests</a>
                        <a class="dropdown-item" href="<?=PROOT?>dashboard/history/userid">History</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=PROOT?>account/logout">Log Out</a>
                    </div>
                </li>
                <li>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </li>

            </ul>
        </div>
    </nav>
</header>
<div class="container">
    <div class="row ">
        <p class="col-3">ID: <?=$posts[0]->id?></p>
        <p class="col-6">Title: <?=$posts[0]->subject?></p>
    </div>

    <div class="row">
        <p class="col-3">Requester: <?=$posts[0]->requester?></p>
        <p class="col-6">Creation Date: <?=$posts[0]->creation_date?></p>
    </div>

    <div class="row">
        <nav class="nav col-6">
            <a class="nav-link active btn btn-primary col-4"
                href="<?=PROOT?>ticket/request/<?=$posts[0]->id?>">Request</a>
            <a class="nav-link btn btn-primary  col-4" href="<?=PROOT?>ticket/resolve/<?=$posts[0]->id?>">Resolution</a>
        </nav>
    </div>

    <div class="row">
        <textarea name="" id="" cols="30" rows="10" class="form-control" disabled><?=$posts[0]->statement?></textarea>
    </div>

    <div class="row">
        <form class="col-12 border" method = "POST" action="<?=PROOT?>ticket/request/<?=$posts[0]->id?>">
            <div class="row">
                <div class="form-group col-12">
                    <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Priority</label>
                    <select name="priority" id="" class="custom-select custom-select-sm">
                        <?=$priorityArray === false ? $priorityArray[0].$priorityArray[$post->id] : $priorityArray[$post->id];?>
                    </select>

                    <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Status</label>
                    <select name="status" id="" class="custom-select custom-select-sm">
                        <option value=""><?=$posts[0]->status?></option>
                    </select>

                    <label for="disabledTextInput" class="btn btn-secondary disabled col-2 ">Assigned
                        Departement</label>

                    <select name="department" id="" class="custom-select custom-select-sm">
                        <?=$depArray === false ? $depArray[0].$depArray[$post->id] : $depArray[$post->id];?>
                    </select>
                </div>
            </div>
            <fieldset disabled="disabled">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Email</label>
                        <input type="text" id="disabledTextInput" class="form-control col-5" width=40px
                            value="<?=$user_info[0]->user_email?>">

                        <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Requester
                            Department</label>
                        <input type="text" id="disabledTextInput" class="form-control col-5" width=40px
                            value="<?=$user_info[0]->dep_name?>">

                        <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Phone</label>
                        <input type="text" id="disabledTextInput" class="form-control col-5"
                            value="<?=$user_info[0]->user_phone?>">
                    </div>
                </div>
            </fieldset>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="updateTicket">Update</button>
        </form>
    </div>
</div>
<?php
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
                        <a class="dropdown-item" href="<?=PROOT?>dashboard/index/userid">Pending requests</a>
                        <a class="dropdown-item" href="<?=PROOT?>dashboard/history/userid">Resolved requests</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=PROOT?>account/logout">Log Out</a>
                    </div>
                </li>
                <li>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </li>

            </ul>
        </div>
    </nav>
</header>

<div class="container">
    <div class="row ">
        <p class="col-3">ID: <?=$posts[0]->id?></p>
        <p class="col-6">Title: <?=$posts[0]->subject?></p>
    </div>

    <div class="row">
        <p class="col-3">Requester: <?=$posts[0]->requester?></p>
        <p class="col-6">Creation Date: <?=$posts[0]->creation_date?></p>
    </div>

    <div class="row">
        <nav class="nav col-6">
            <a class="nav-link active btn btn-primary col-4"
                href="<?=PROOT?>ticket/request/<?=$posts[0]->id?>">Request</a>
            <a class="nav-link btn btn-primary  col-4" href="<?=PROOT?>ticket/resolve/<?=$posts[0]->id?>">Resolution</a>
        </nav>
    </div>

    <div class="row">
        <textarea name="" id="" cols="30" rows="10" class="form-control" disabled><?=$posts[0]->statement?></textarea>
    </div>

    <div class="row">
        <form class="col-12 border">
            <div class="row">
                <div class="form-group col-12">
                    <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Priority</label>
                    <select name="" id="" class="custom-select custom-select-sm" disabled>
                        <option value=""><?=$posts[0]->priority?></option>
                    </select>

                    <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Status</label>
                    <select name="" id="" class="custom-select custom-select-sm" disabled>
                        <option value=""><?=$posts[0]->status?></option>
                    </select>

                    <label for="disabledTextInput" class="btn btn-secondary disabled col-2 ">Assigned
                        Departement</label>

                    <select name="" id="" class="custom-select custom-select-sm" disabled>
                        <option value=""><?=$posts[0]->dep_name?></option>
                    </select>
                </div>
            </div>
            <fieldset disabled="disabled">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Email</label>
                        <input type="text" id="disabledTextInput" class="form-control col-5" width=40px
                            value="<?=$user_info[0]->user_email?>">

                        <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Requester
                            Department</label>
                        <input type="text" id="disabledTextInput" class="form-control col-5" width=40px
                            value="<?=$user_info[0]->dep_name?>">

                        <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Phone</label>
                        <input type="text" id="disabledTextInput" class="form-control col-5"
                            value="<?=$user_info[0]->user_phone?>">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<?php
}
?>
<?= $this->end();?>