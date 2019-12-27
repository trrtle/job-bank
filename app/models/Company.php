<?php
/**
 * models/Company.php - Handels Company related database interaction.
 *
 * @package    TurtleMVC-Core
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 */

/**
 * Company model class  - Handels Company related database interaction
 *
 * Creates database connection.
 * Register a company
 * company login
 *
 * @property object $db - Database() object.
 */

class Company{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @method login - Login a Company
     *
     * 1. Searches for user in the db.
     * 2. if user is found checks if given password match.
     *
     * @param string $username - Username of the user that tries to login
     * @param string $secret - Password of the user that tries to login
     *
     * @return bool
     */
    public function login($username, $secret){
        // search if the user exists
        $row = $this->findCompByLogin($username);
        if($row){
            // check if passwords match
            if(password_verify($secret, $row->comp_secret)){
                return $row;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * @method FindCompByLogin;
     *
     * 1. prepares statement.
     * 2. binds values.
     * 3. stores result in $row
     * 4. checks if there are more than 0 rows returned
     *
     * @param string $login - Username OR email that must be searched.
     *
     * @return object - PDO row object.
     */
    public function findCompByLogin($login){
        // prepare statement
        $this->db->query("SELECT * FROM companys WHERE comp_username = :login OR comp_email = :login ;");
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



    /**
     * @method FindCompbyEmail;
     *
     * 1. prepares statement.
     * 2. binds values.
     * 3. stores result in $row
     * 4. checks if there are more than 0 rows returned
     *
     * @param string $email - Email that must be searched.
     *
     * @return bool
     */
    public function findCompByEmail($email){
        // prepare statement
        $this->db->query("SELECT * FROM companys WHERE comp_email = :email ;");
        // bind value
        $this->db->bind(":email", $email);
        // execute and get row
        $row = $this->db->resultRow();

        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findCompById($id){
        // prepare statement
        $this->db->query("SELECT * FROM companys WHERE comp_id = :id ;");
        // bind value
        $this->db->bind(":id", $id);
        // execute and get row
        $row = $this->db->resultRow();

        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    // update Email adress
    public function updateEmail($newEmail){

        $sql = "UPDATE companys SET comp_email = :email WHERE companys.comp_id = :id";

        $this->db->query($sql);
        $this->db->bind(":email", $newEmail);
        $this->db->bind(":id", $_SESSION['comp_id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    // update password
    public function updateSecret($newSecret){
        $newSecret = password_hash($newSecret, PASSWORD_DEFAULT);

        $sql = "UPDATE companys SET comp_secret = :secret WHERE companys.comp_id = :id";

        $this->db->query($sql);
        $this->db->bind(":secret", $newSecret);
        $this->db->bind(":id", $_SESSION['comp_id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}



