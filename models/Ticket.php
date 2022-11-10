<?php

class Ticket {

    private $table = "tl_ticket";
    private $db;
    public function __construct($connection) {
        $this->db = $connection;
    }

    // function to save data to table tl_ticket
    public function store($data) {
        $prepareInsert = self::prepareInsert($data);
        $sql = "INSERT INTO ticketing.$this->table $prepareInsert->column VALUES $prepareInsert->rows";
  
        // query execute
        $query = $this->db->query($sql);
        if ($query == false) {
            print_r(mysqli_error($db));
        }
        $this->db->close();
    
    }

    // function to check ticket
    public function checkTicketCode($params) {
        $ticketDetail = array();
        $sql = "SELECT * FROM  ticketing.$this->table WHERE event_id = ? AND ticket_code = ?";

        // prepare query before execute
        $statement = $this->db->prepare($sql);
        $statement->bind_param("is", $params->event_id, $params->ticket_code);
        $statement->execute();

        if ($result = $statement->get_result()) {
            // result set
            while ($row = $result->fetch_array()) {
                $ticketDetail = array(
                    "ticket_code" => $row['ticket_code'],
                    "status" => $row['status']
                );
            }

        }
        $this->db->close();

        return $ticketDetail;
        
    }

    // function to update ticket
    public function updateTicketStatus($params) {
        $result = array();
        $updated = false;
        $update_at = Date("Y-m-d H:i:s");
        $sql = "UPDATE ticketing.$this->table SET `status` = ?, updated_date = ? WHERE event_id = ? AND ticket_code = ?";

        // prepare query before execute
        $statement = $this->db->prepare($sql);
        if (!$statement) {
            $result = array(
                'message' => $this->db->error
            );
            return ['updated' => $updated, 'data' => $result];
        }

        $statement->bind_param("ssis", $params->status, $update_at, $params->event_id, $params->ticket_code);
        
        // execute prepared statement
        if ( $statement->execute() && $statement->affected_rows > 0) {
            $updated = true;
            // check ticket 
            $result = self::checkTicketCode($params);
            $result['update_at'] = $update_at;

        } else {
            $result = array(
                'message' => "Data ticket could not be updated"
            );
        }

        return ['updated' => $updated, 'data' => $result];
        
    }

    // function to prepare query insert data
    public function prepareInsert($data) {
        $column = array();
        $row = array();
        for ($i = 0; $i < count($data); $i++) {

            // define temporary container for each value of $data[$i]
            $temp = array();
            foreach ($data[$i] as $key => $value) {
                if ($i == 0) {
                    // define column to be insert
                    array_push($column, $key);
                }

                // determine type of value 
                $temp[$key] = gettype($value) == "integer" ? $value : "'" . $value . "'";
            }

            // build parameter value of $temp
            array_push($row, "(". implode(", ", $temp) .")");
        }

        // return a json using stdclass
        return json_decode(json_encode(
            [
                'column' => "(" . implode(", ", $column) . ")",
                'rows' => implode(", ", $row)
            ]
        ));

    }

}