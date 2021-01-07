<?= $this->start("body")?>

<?php


if(!$_SESSION['userName']){
    //put error header here
    header(LOGIN_REDIRECT);
}

//extract all data coming from control
 if(extract($var)){
    //print_r($posts);
    //if there are no posts that mean the ticket should not be opened, thus redirecting to error page
    if(empty($posts)){
        header(PAGE_NOT_FOUND);
    }
    
    
        $statTemp = false;
        $statArray = array("unassigned");
        $statOptions = "";
        foreach($posts as $post){
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
            <a class="nav-link btn btn-primary col-4" href="<?=PROOT?>ticket/request/<?=$posts[0]->id?>">Request</a>
            <a class="nav-link active btn btn-primary  col-4"
                href="<?=PROOT?>ticket/resolve/<?=$posts[0]->id?>">Resolution</a>
        </nav>
    </div>

    <form method="POST" action="<?=PROOT?>ticket/resolve/<?=$posts[0]->id?>">
        <div class="row">
            <textarea name="resolution" id="" cols="30" rows="10" placeholder="Resolution"
                class="form-control"><?=$posts[0]->resolution?></textarea>
        </div>


        <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Status</label>
        <select name="status" id="" class="custom-select custom-select-sm">
        <?=$statTemp === false ? $statArray[0].$statArray[$post->id] : $statArray[$post->id];?>
        </select>

        <br>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="updateTicket">Update</button>
    </form>
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
            <a class="nav-link btn btn-primary col-4" href="<?=PROOT?>ticket/request/<?=$posts[0]->id?>">Request</a>
            <a class="nav-link active btn btn-primary  col-4"
                href="<?=PROOT?>ticket/resolve/<?=$posts[0]->id?>">Resolution</a>
        </nav>
    </div>

    <form method="POST" action="<?=PROOT?>ticket/resolve/<?=$posts[0]->id?>">
        <div class="row">
            <textarea name="resolution" id="" cols="30" rows="10" placeholder="Resolution" class="form-control"
                disabled><?=$posts[0]->resolution?></textarea>
        </div>


        <label for="disabledTextInput" class="btn btn-secondary disabled col-2">Status</label>
        <select name="status" id="" class="custom-select custom-select-sm" disabled>
        <?=$statTemp === false ? $statArray[0].$statArray[$post->id] : $statArray[$post->id];?>
        </select>

        <br>
        <br>
    </form>
</div>
<?php
}
?>
<?= $this->end();?>