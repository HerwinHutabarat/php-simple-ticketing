<?php

include "./models/Ticket.php";
include "./config/database.php";

function generateTicket($argv) {
    // validate the input parameters
    $params = count($argv);
    switch ($params) {
        case 2:
            echo "\nYou must input number of ticket to be generated\n\n";
            die();
        case 3:
            break;
        
        default:
            echo "\nYou must input at least 2 parameters\nexample : php generate_ticket.php 2 3000\n\n";
            die();
    }

    // set id of ticket to save them into database
    $eventId = (int) $argv[1];
    
    // define counter to set quantity of ticket to be generate
    $counter = (int) $argv[2];

    if ( $eventId == 0 || $counter == 0) {
        echo "\nYou must input a valid number\n\n";
        die();
    } else if ($counter > 47500) {
        echo "\nMaximum allowed number of ticket could be less than 47500\n\n";
        die();
    }

    // set container to the ticket 
    $ticket = array();

    // set prefix to identify ticket
    $prefix = "DTK";
    
    // set pattern of ticket after prefix
    $pattern = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    
    // create ticket of number $counter
    for ($i = 1; $i <= $counter; $i++) {
        // generate each ticket base on $pattern
        $generatedTicket = array("event_id" => $eventId, "ticket_code" => $prefix . substr(str_shuffle($pattern), 0, 10));

        // push the generated ticket into container
        $ticket[] = $generatedTicket;
    }

    // store the ticket
    $connection = new Database;
    $ticketModel = new Ticket($connection->init());
    $ticketModel->store($ticket);

}

generateTicket($argv);