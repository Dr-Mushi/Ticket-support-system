<?php
session_start();

//when user request a new ticket page
class RequestFormController extends Controller{
    public function indexAction(){
        $department = new AccountModel('departments');
        $ticket = new TicketModel("tickets");
        $users = new AccountModel('users');

        if(isset($_POST['submit'])){
            $subject = $_POST['inputTitle'];
            $statement = $_POST['inputStatement'];
            $dep = $_POST['inputDepartement'];



            //take current date
            $creation_time = date('Y-m-d h:i:s');

            //get the logged in user data 
            $userObj = $users->getUser(SESSION::get('userName'));

            //get department id from choosen department
            $dep = $department->gerDepartment($dep);
           
            //check if the fields are empty
            if($ticket->emptyCheckTicket($subject,$statement)){
                //check if the title exceeds the maximum characters (40)
                if($ticket->checkStringSize($subject,40)){
                    $ticket->setTicket([
                        "subject" => $subject,
                        "statement"=> $statement,
                        "resolution"=>'',
                        "requester"=>$userObj->id,
                        "assigned_to"=>NULL,
                        "priority" => 1,
                        "assigned_dep" => 1,
                        "status" => 1,
                        "creation_date" => $creation_time
                    ]);
                }
                
            }

            

            
            header(DASHBOARD_REDIRECT. "?success=ticketcreated");
        }else{
            
            $deps = $department->getDepartments();
            
            $this->view->render('ticket_system/requestForm',["deps"=>$deps]);

        }
    }

}