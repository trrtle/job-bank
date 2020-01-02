<?php
class Offer {

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllOffersByCompId($id){
        $sql = "select * from offers WHERE comp_id = :id ORDER BY offer_date DESC";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->resultSet();
    }

    public function getOfferById($id){
        $sql = "select * from offers WHERE offer_id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        return $this->db->resultRow();
    }

    public function addOffer($offerTitle, $offerDesc, $offerTags){
        $sql = "INSERT INTO offers (comp_id, offer_title, offer_desc, offer_tags) 
                VALUES (:comp_id, :offer_title, :offer_desc, :offer_tags)";
        $this->db->query($sql);
        $this->db->bind(":comp_id", $_SESSION['comp_id']);
        $this->db->bind(':offer_title', $offerTitle);
        $this->db->bind(":offer_desc", $offerDesc);
        $this->db->bind(':offer_tags', $offerTags);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function updateOffer($offerId, $offerTitle, $offerDesc, $offerTags){
        $sql = "UPDATE offers SET 
                offer_title = :offer_title, 
                offer_desc = :offer_desc, 
                offer_tags = :offer_tags 
                WHERE offers.offer_id = :offer_id;";

        $this->db->query($sql);
        $this->db->bind(':offer_title', $offerTitle);
        $this->db->bind(":offer_desc", $offerDesc);
        $this->db->bind(':offer_tags', $offerTags);
        $this->db->bind(':offer_id', $offerId);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}