<?php
session_start();

//inside ticket page
class TicketController extends Controller{
    public function indexAction(){
       header(PAGE_NOT_FOUND);
    }

    public function requestAction($id=""/* ,$d="" */){
        $ticket = new TicketModel("tickets");
        if(isset($_POST['updateTicket'])){
            $priority =  $_POST['priority'];
            $status = $_POST['status'];
            $dep = $_POST['department'];



            $fields = [
                "priority"=>$priority,
                "status"=>$status,
                "assigned_dep "=>$dep
            ];

            if($ticket->updateTicket($id,$fields)){
                header(DASHBOARD_REDIRECT. "?success=ticketupdate");
            }else{
                header(DASHBOARD_REDIRECT. "?error=ticketupdate");
            }

        }else{
            $priority = "";
            $department = "";
            $status = "";

            
            $department = new AccountModel('departments');

            $dep = $department->getDepartmentID($_SESSION['userDep']);
            //prevent user to go to other tickets that do not belong to him by changing URL ID
            if($_SESSION['userType'] === "employee"){
                //if the user is employee he can traverse all tickets with the same dep_name
                $query = $ticket->getTicket("SELECT * FROM view_tickets Where id = $id AND dep_name = '".$dep->dep_name."'");
            }else{
                //if the user is a requester he can traverse all tickets with the same requester id
                $query = $ticket->getTicket("SELECT * FROM view_tickets Where id = $id AND requester_id = '".$_SESSION['userId']."'");
            }
            //get information of the requester to put into the ticket such as phone number
            $user_info = $ticket->getTicket("SELECT * FROM `user_dep_joined` WHERE userid =". $query[0]->requester_id." ");
            
            //check if the ticket id exist
            if(empty($query)){
                $this->view->render('ticket_system/resolve',["posts"=>false]);
            }
            $priority = $ticket->getTicket("SELECT * FROM `priority` ");
            $department = $ticket->getTicket("SELECT * FROM `departments` ");
            $status = $ticket->getTicket("SELECT * FROM `status` ");





            $this->view->render('ticket_system/request',
            [
                "posts"=>$query,
                "user_info"=>$user_info,
                "priority"=>$priority,
                "department"=>$department,
                "status"=>$status,
                ]
            );
        }
    }

    public function resolveAction($id=""){
        $ticket = new TicketModel("tickets");

        if(isset($_POST['updateTicket'])){

            $resolution = $_POST['resolution'];
            $status = $_POST['status'];


            $fields = [
                "resolution"=>$resolution,
                "status"=>$status,
                "assigned_to"=>$_SESSION['userId']
            ];

            if($ticket->updateTicket($id,$fields)){
                header(DASHBOARD_REDIRECT. "?success=ticketupdate");
            }else{
                header(DASHBOARD_REDIRECT. "?error=ticketupdate");
            }

        }else{

            $status = ""; 
            $status = $ticket->getTicket("SELECT * FROM `status` ");

            $department = new AccountModel('departments');

            $dep = $department->getDepartmentID($_SESSION['userDep']);
            //prevent user to go to other tickets that do not belong to him by changing URL ID
            if($_SESSION['userType'] === "employee"){
                //if the user is employee he can traverse all tickets with the same dep_name
                $query = $ticket->getTicket("SELECT * FROM view_tickets Where id = $id AND dep_name = '".$dep->dep_name."'");
            }else{
                //if the user is a requester he can traverse all tickets with the same requester id
                $query = $ticket->getTicket("SELECT * FROM view_tickets Where id = $id AND requester_id = '".$_SESSION['userId']."'");
            }
            if(empty($query)){
                $this->view->render('ticket_system/resolve',["posts"=>false]);
            }
            $this->view->render('ticket_system/resolve',["posts"=>$query,"status"=>$status]);
        }
        
    }
}