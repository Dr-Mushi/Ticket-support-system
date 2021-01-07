<?php


class TicketModel extends Model{
    private $subject = "",$statement = "";
    public function __construct($table){
        parent::__construct($table);
    }

    //create new ticket and insert it into database
    public function setTicket($fields){
        //dnd($fields);
        $query = $this->insert($fields);
        //dnd($query);
        return $query;
    }

    public function getTicket($fields){
       
      return $query = $this->query($fields);

    }

    public function updateTicket($id,$fields){
        return $this->update($id,$fields);
    }



    //check if any field is empty.
    public function emptyCheckTicket($subject,$statement){
        //remove all spaces
        $subject = str_replace(' ', '', $subject);
        $statement = str_replace(' ', '', $statement);
        if(empty($subject) || empty($statement)){
            header(NEW_TICKET_REDIRECT . "?error=emptyfields&subject=" . $subject . "&statement=" . $statement);
            exit();    
        }
        $this->subject = $subject;
        $this->statement = $statement;
        return true;
    }

    //if the str exceeds the maximum size, launch an erro.
    public function checkStringSize($str, $size){
        if(strlen($str) > $size){
            header(NEW_TICKET_REDIRECT . "?error=maximumExceed&subject=" . $this->subject . "&statement=" . $this->statement);
            exit();  
        }
        return true;
    }
}