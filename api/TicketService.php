<?php 

include_once "./models/Ticket.php";
include_once "./config/database.php";

class TicketService {

    private $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function checkTicketCode() {
        // Parameters validation
        if ( !isset($this->request->event_id) || $this->request->event_id == '' ) {
            self::send(400, ['event_id is required']);
        } else if ( !isset($this->request->ticket_code) || $this->request->ticket_code == '' ) {
            self::send(400, ['ticket_code is required']);            
        }

        $connection = new Database;
        $tickets = new Ticket ($connection->init());
        $result = $tickets->checkTicketCode($this->request);
        
        if ( count($result) < 1 ) {
           self::send(404, null);
        }
        self::send(200, $result);
    }

    public function updateStatusTicket() {
        // Parameters validation
        if ( !isset($this->request->event_id) || $this->request->event_id == '' ) {
            self::send(400, ['event_id is required']);
        } else if ( !isset($this->request->ticket_code) || $this->request->ticket_code == '' ) {
            self::send(400, ['ticket_code is required']);            
        }

        $statusEnum = ['available', 'claimed'];
        if (!in_array($this->request->status, $statusEnum)) {
            self::send(400, 'invalid status, must be one of list (' . implode(", ", $statusEnum) . ')');
        }

        $connection = new Database;
        $tickets = new Ticket ($connection->init());
        $result = $tickets->updateTicketStatus($this->request);

        if ( !$result['updated'] ) {
           self::send(500, $result['data']);
        }
        self::send(200, $result['data']);

    }

    public function send($code, $data = null) {
        http_response_code((int)$code);
        echo json_encode(['code' => $code, 'data' => $data]);
        exit;
    }        

}