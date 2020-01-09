<?php

class Response{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function addResponse($offer_id, $resp_text, $user_id){
        $sql = "INSERT INTO response (offer_id, resp_text, user_id) 
                VALUES (:offer_id, :resp_text, :user_id);";
        $this->db->query($sql);
        $this->db->bind(":offer_id", $offer_id);
        $this->db->bind(":resp_text", $resp_text);
        $this->db->bind(":user_id", $user_id);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getAllRespsByUserId($user_id){
        $sql = "SELECT R.resp_text AS resp_text, R.resp_date AS resp_date, 
                O.offer_title AS offer_title, O.offer_desc AS offer_desc, O.offer_date AS offer_date
                FROM response R JOIN offers O ON R.offer_id=O.offer_id 
                WHERE user_id = :user_id ORDER BY resp_date DESC";
        $this->db->query($sql);
        $this->db->bind(":user_id", $user_id);
        return $this->db->resultSet();
    }

}
