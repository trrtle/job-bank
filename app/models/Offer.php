<?php
class Offer {

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllOffersByCompId($id){
        $sql = "select * from offers WHERE comp_id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->resultSet();
    }

    public function addOffer($offerTitle, $offerDesc, $offer_tags){
        $sql = "INSERT INTO offers (comp_id, offer_title, offer_desc, offer_tags) 
                VALUES (:comp_id, :offer_title, :offer_desc, :offer_tags)";
        $this->db->query($sql);
        $this->db->bind(":comp_id", $_SESSION['comp_id']);
        $this->db->bind(':offer_title', $offerTitle);
        $this->db->bind(":offer_desc", $offerDesc);
        $this->db->bind(':offer_tags', $offer_tags);
        $this->db->execute();
    }
}