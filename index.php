<?php 

// Load Ticket Service
include "./api/TicketService.php";

// Set header for response handling
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Identify url method for handling api service
$uri = explode("/", $_SERVER['REQUEST_URI']);
$path = "";
for ($i = 0; $i < count($uri); $i++) {
    if ($uri[$i] != '') {
        $path .= "/" . $uri[$i];
    }
}

// Load input to the request object
$request = json_decode(file_get_contents("php://input"));
$ticket = new TicketService($request);

// Manual Route
switch (rtrim($path, "/")) {
    case '/ticket/check':
        $_SERVER['REQUEST_METHOD'] == 'POST' ? $ticket->checkTicketCode() : terminated(405, 'Method Not Allowed');
        break;
    
    case '/ticket/update':
        $validated = $_SERVER['REQUEST_METHOD'] == 'POST' ? $ticket->updateStatusTicket() : terminated(405, 'Method Not Allowed');
        break;

    default:
        terminated(404, 'Not Found');
        break;
}

function terminated($code, $msg) {
    echo json_encode(['code' => $code, 'message' => $msg]);
}

