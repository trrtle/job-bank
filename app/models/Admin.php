<?php


class Admin
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($username, $secret)
    {
        // search if the user exists
        $row = $this->findAdminByLogin($username);
        if ($row) {
            // check if passwords match
            if (password_verify($secret, $row->secret)) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function findAdminByLogin($login)
    {
        // prepare statement
        $this->db->query("SELECT * FROM admins WHERE username = :login;");
        // bind value
        $this->db->bind(":login", $login);
        // execute and get row
        $row = $this->db->resultRow();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function getAllComps()
    {

        $this->db->query("select * from companys where comp_username IS NOT NULL;");

        $set = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $set;
        } else {
            return false;
        }
    }

    public function delComp($comp_id)
    {
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

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editComp($data)
    {
        $sql = "UPDATE companys SET 
        comp_username = :username, 
        comp_email = :email, 
        comp_name = :comp_name,
        comp_city = :city
        WHERE comp_id = :id;";

        $this->db->query($sql);

        $this->db->bind(":username", $data['username']);
        $this->db->bind(":email", $data['email']);
        $this->db->bind(":comp_name", $data['comp-name']);
        $this->db->bind(":city", $data['city']);
        $this->db->bind(":id", $data['id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllUsers(){
        $this->db->query("select * from users where username IS NOT NULL;");

        $set = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $set;
        } else {
            return false;
        }
    }

    public function delUser($id){
        $sql = "UPDATE users SET 
        username = NULL, 
        email = NULL, 
        secret = NULL, 
        created = NULL,
        firstname = NULL,
        lastname = NULL,
        city = NULL,
        image = NULL,
        age = NULL,
        gender = NULL,
        token = NULL    
        WHERE id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


}