<?php
session_start();

//dashboard for users to see their tickets
class DashboardController extends Controller{
    public function indexAction($userID = ""){
        $priority = "";
        $department = "";
        $status = "";
        $users = "";

        $ticket = new TicketModel("tickets");
        $department = new AccountModel('departments');
        $dep = $department->getDepartmentID($_SESSION['userDep']);
         //if the user is employee
        if($_SESSION['userType'] === "employee"){
            
        //select all tickets from the user department
           
            $query = $ticket->getTicket("SELECT * FROM `view_tickets`
            WHERE status = 'onhold'
            AND dep_name ='".$dep->dep_name."'
            ORDER BY creation_date DESC");
            
            
        $priority = $ticket->getTicket("SELECT * FROM `priority` ");
        $department = $ticket->getTicket("SELECT * FROM `departments` ");
        $status = $ticket->getTicket("SELECT * FROM `status` ");
        
        //select all users from the same department
        $users = $ticket->getTicket(
        "SELECT * FROM `users`
        WHERE user_dp_name = '".$_SESSION['userDep']."'
        AND user_type = 'employee'"
        );
        
        
        
        //if the user is requester
        }else{
            $query = $ticket->getTicket("SELECT * FROM `view_tickets`
             WHERE status = 'onhold'
            AND requester = '".$_SESSION['userName']."'
            ORDER BY creation_date DESC");
        }

        $this->view->render('ticket_system/dashboard',
        [
        "posts"=>$query,
        "priority"=>$priority,
        "department"=>$department,
        "status"=>$status,
        "users" =>$users
        ]);
    }
    
    public function myRequestsAction($userID = ""){
        $priority = "";
        $department = "";
        $status = "";
        $users = "";

        $ticket = new TicketModel("tickets");
        //select all tickets that assigned to the user only
        $query = $ticket->getTicket("SELECT * FROM `view_tickets`
         WHERE status = 'onhold'
         AND assigned_to = '".$_SESSION['userName']."'
         ORDER BY creation_date DESC");
        
        $priority = $ticket->getTicket("SELECT * FROM `priority` ");
        $department = $ticket->getTicket("SELECT * FROM `departments` ");
        $status = $ticket->getTicket("SELECT * FROM `status` ");

        //select all users from the same department
        $users = $ticket->getTicket(
        "SELECT * FROM `users`
        WHERE user_dp_name = '".$_SESSION['userDep']."'
        AND user_type = 'employee'"
        );

        $this->view->render('ticket_system/myRequests',
        [
            "posts"=>$query,
            "priority"=>$priority,
            "department"=>$department,
            "status"=>$status,
            "users" =>$users
        ]);
    }

    public function historyAction($userID = ""){
        $status = "";

        
        $ticket = new TicketModel("tickets");

        
        $department = new AccountModel('departments');
        $dep = $department->getDepartmentID($_SESSION['userDep']);

        $status = $ticket->getTicket("SELECT * FROM `status` ");
        //if the user is employee
        if($_SESSION['userType'] === "employee"){
        //select all tickets that are not onhold status
        $query = $ticket->getTicket("SELECT * FROM `view_tickets`
         WHERE status != 'onhold'
         AND dep_name ='".$dep->dep_name."'
         ORDER BY creation_date DESC");
        
        //if the user is requester
        }else{
            $query = $ticket->getTicket("SELECT * FROM `view_tickets` WHERE status != 'onhold'
             AND requester = '".$_SESSION['userName']."'
             ORDER BY creation_date DESC");
        }
        $this->view->render('ticket_system/history',["posts"=>$query,"status"=>$status]);
    }

    //updating form data with ajax
    public function ajaxAction($type=""){
        //take the type of data the user changed
        if(isset($_POST[$type])){
        
            $ticket = new TicketModel("tickets");
            $id =  $_POST["ticket"];
            $typeTemp = $_POST[$type];
            //if the data is null then set the data in db to NULL
            if($typeTemp === "NULL"){
                $typeTemp = NULL;
            }
            //if the type is assigned_dep then change the department and make the assigned to = NULL
            if($type === "assigned_dep"){
                $fields = [
                    "assigned_dep"=>$typeTemp,
                    "assigned_to"=>NULL
                ];
                
                $ticket->updateTicket($id,$fields);
            //if it's any other data then update it normally
            }
            //if the user changed the status to cancelled or resolved it will be assigned to him
            if($type === "status" && ($typeTemp == 2 || $typeTemp == 3)){
                $fields = [
                    $type=>$typeTemp,
                    "assigned_to"=>$_SESSION['userId']
                ];
                
                $ticket->updateTicket($id,$fields);
            }
            else{
                $fields =[$type=>$typeTemp];

                $ticket->updateTicket($id,$fields);
            }   
        }
        /* elseif(isset($_POST["status"])){

        } */
    }
    public function searchAction(){
        $priority = "";
        $department = "";
        $status = "";
        $users = "";
        $search = "";

        $ticket = new TicketModel("tickets");
        $search = $_POST["search"];


        $priority = $ticket->getTicket("SELECT * FROM `priority` ");
        $department = $ticket->getTicket("SELECT * FROM `departments` ");
        $status = $ticket->getTicket("SELECT * FROM `status` ");

        //select all users from the same department
        $users = $ticket->getTicket(
            "SELECT * FROM `users`
            WHERE user_dp_name = '".$_SESSION['userDep']."'
            AND user_type = 'employee'"
            );

        if(isset($_POST["searchDashboard"])){
            
            /* $query = $ticket->getTicket("SELECT * FROM `view_tickets` WHERE `id` LIKE '%$search%' "); */
            
            if($_SESSION['userType'] === "employee"){
                $department = new AccountModel('departments');
                $dep = $department->getDepartmentID($_SESSION['userDep']);
    
               
                $query = $ticket->getTicket("SELECT * FROM `view_tickets`
                WHERE status = 'onhold'
                AND dep_name ='".$dep->dep_name."'
                AND  `id` LIKE '%$search%'
                ORDER BY creation_date DESC");
                
                
                
                
                
            
                
            }else{
                $query = $ticket->getTicket("SELECT * FROM `view_tickets`
                WHERE status = 'onhold'
               AND requester = '".$_SESSION['userName']."'
               AND  `id` LIKE '%$search%'
               ORDER BY creation_date DESC");
            }
            $this->view->render('ticket_system/dashboard',
            [
            "posts"=>$query,
            "priority"=>$priority,
            "department"=>$department,
            "status"=>$status,
            "users" =>$users
            ]);
            
        }
        elseif(isset($_POST["searchMyRequests"])){

            $ticket = new TicketModel("tickets");
            //select all tickets that assigned to the user only
            $query = $ticket->getTicket("SELECT * FROM `view_tickets`
             WHERE status = 'onhold'
             AND assigned_to = '".$_SESSION['userName']."'
             AND `id` LIKE '%$search%'
             ORDER BY creation_date DESC");

        
            $this->view->render('ticket_system/myRequests',
            [
                "posts"=>$query,
                "priority"=>$priority,
                "department"=>$department,
                "status"=>$status,
                "users" =>$users
            ]);
        }

        elseif(isset($_POST["searchHistory"])){
            $department = new AccountModel('departments');
            $dep = $department->getDepartmentID($_SESSION['userDep']);
            //select all tickets that are not onhold status
            $ticket = new TicketModel("tickets");
            //if the user is employee
            if($_SESSION['userType'] === "employee"){

            $query = $ticket->getTicket("SELECT * FROM `view_tickets`
            WHERE status != 'onhold'
            AND `id` LIKE '%$search%'
            AND dep_name ='".$dep->dep_name."'
            ORDER BY creation_date DESC ");
            //if the user is requester
            }else{
                $query = $ticket->getTicket("SELECT * FROM `view_tickets`
                WHERE status != 'onhold'
                AND requester = '".$_SESSION['userName']."'
                AND `id` LIKE '%$search%'
                ORDER BY creation_date DESC");
            }
            $this->view->render('ticket_system/history',
            [
                "posts"=>$query,
                "priority"=>$priority,
                "department"=>$department,
                "status"=>$status,
                "users" =>$users
                ]);
        }
    }

    
}