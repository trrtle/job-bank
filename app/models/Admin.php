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


}