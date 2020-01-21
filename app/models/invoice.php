<?php


class invoice
{
    private $db;
    private $offerModel;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getRespsByOfferForInvoice($offer_id){
        $sql = "SELECT  R.resp_id AS resp_id, R.resp_date AS resp_date, O.offer_id AS offer_id, O.offer_title AS offer_title, U.username AS username
                FROM response as R JOIN offers as O ON R.offer_id=O.offer_id JOIN users as U ON R.user_id=U.id
                WHERE R.offer_id = :offer_id GROUP BY username";
        $this->db->query($sql);
        $this->db->bind(":offer_id", $offer_id);
        return $this->db->resultSet();
    }

    public function insertInvoice($resp_id, $offer_id, $user_id){
        $sql = "INSERT INTO invoices (resp_id, offer_id, user_id) VALUES (:resp_id, :offer_id, :user_id);";
        $this->db->query($sql);
        $this->db->bind(":resp_id", $resp_id);
        $this->db->bind(":offer_id", $offer_id);
        $this->db->bind(":user_id", $user_id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getInvoice($resp_id, $offer_id, $user_id){
        $sql = "SELECT * FROM `invoices` WHERE resp_id = :resp_id AND offer_id = :offer_id AND user_id = :user_id ";

        $this->db->query($sql);
        $this->db->bind(":resp_id", $resp_id);
        $this->db->bind(":offer_id", $offer_id);
        $this->db->bind(":user_id", $user_id);

        $row = $this->db->resultRow();
        if(!empty($row)){
            return $row;
        }else{
            return false;
        }
    }
}