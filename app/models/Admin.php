<?php


class Admin{
    protected $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($username, $secret){
        // search if the user exists
        $row = $this->findAdminByLogin($username);
        if($row){
            // check if passwords match
            if(password_verify($secret, $row->secret)){
                return $row;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function findAdminByLogin($login){
        // prepare statement
        $this->db->query("SELECT * FROM admins WHERE username = :login;");
        // bind value
        $this->db->bind(":login", $login);
        // execute and get row
        $row = $this->db->resultRow();

        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function getAllComps(){

        $this->db->query("select * from companys where comp_username IS NOT NULL;");

        $set = $this->db->resultSet();

        if($this->db->rowCount() > 0){
            return $set;
        }else{
            return false;
        }
    }

    public function delComp($comp_id){
        $sql = "UPDATE companys SET 
        comp_username = NULL, 
        comp_email = NULL, 
        comp_secret = NULL, 
        comp_name = NULL,
        comp_city = NULL,
        comp_image = NULL,
        token = NULL    
        WHERE comp_id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $comp_id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function addComp($username, $email, $secret, $name, $city){
        $sql = "INSERT INTO companys (comp_username, comp_email. comp_secret, comp_name, comp_city)
                VALUES (:username, :email, :secret, :comp_name, :city)";

        $this->db->bind(':username', $username);
        $this->db->bind(':email', $email);
        $this->db->bind(':secret', $secret);
        $this->db->bind(':comp_name', $name);
        $this->db->bind(':city', $city);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }


}