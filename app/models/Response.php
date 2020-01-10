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
        $sql = "SELECT R.resp_text AS resp_text, R.resp_date AS resp_date, R.resp_id AS resp_id,
                O.offer_title AS offer_title, O.offer_desc AS offer_desc, O.offer_date AS offer_date
                FROM response R JOIN offers O ON R.offer_id=O.offer_id 
                WHERE user_id = :user_id ORDER BY resp_date DESC;";
        $this->db->query($sql);
        $this->db->bind(":user_id", $user_id);
        return $this->db->resultSet();
    }

    public function getRespById($resp_id){
        $sql = "SELECT R.resp_text AS resp_text, R.resp_date AS resp_date, R.resp_id AS resp_id,
                O.offer_title AS offer_title, O.offer_desc AS offer_desc, O.offer_date AS offer_date
                FROM response R JOIN offers O ON R.offer_id=O.offer_id 
                WHERE R.resp_id = :resp_id;";
        $this->db->query($sql);
        $this->db->bind(":resp_id", $resp_id);
        return $this->db->resultRow();
    }

    public function getRespsByOffer($offer_id){
        $sql = "SELECT R.*, O.offer_title, O.offer_date, U.firstname, U.lastname, U.username
                FROM response as R JOIN offers as O ON R.offer_id=O.offer_id JOIN users as U ON R.user_id=U.id
                WHERE R.offer_id = :offer_id";
        $this->db->query($sql);
        $this->db->bind(":offer_id", $offer_id);
        return $this->db->resultSet();
    }


//    public function countRespOnOffer($offer_id){
//        $sql = "SELECT * FROM response WHERE offer_id = :offer_id";
//        $this->db->query($sql);
//        $this->db->bind(":offer_id", $offer_id);
//        return $this->db->rowCount();
//    }


}
