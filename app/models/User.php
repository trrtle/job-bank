<?php
/**
 * models/User.php - Handels user related database interaction.
 *
 * @package    TurtleMVC-Core
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 */

/**
 * User model class  - Handels user related database interaction
 *
 * Creates database connection.
 * Register a user
 * User login
 * Search database for User by username, email or both.
 *
 * @property object $db - Database() object.
 */

class User{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @method registerUser - Register a user
     *
     * 1. Prepares insert statement.
     * 2. Binds insert statement.
     * 3. execute insert statement.
     *
     * @param array $credentials - array with the following creds: username, email, secret.
     *
     * @return bool
     */
    public function registerUser($credentials){
        // prepare statement
        $this->db->query("INSERT INTO users (username, email, secret) VALUES (:username, :email, :secret)");

        // bind values
        $this->db->bind(':username', $credentials['username']);
        $this->db->bind(':email', $credentials['email']);
        $this->db->bind(':secret', $credentials['secret']);

        // execute statement
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @method login - Login a user
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
        $row = $this->findUserByLogin($username);
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

    /**
     * @method FindUserbyUsername;
     *
     * 1. prepares statement.
     * 2. binds values.
     * 3. stores result in $row
     * 4. checks if there are more than 0 rows returned
     *
     * @param string $username - Username that must be searched.
     *
     * @return bool
     */
    public function findUserByUsername($username){
        // prepare statement
        $this->db->query("SELECT * FROM users WHERE username = :username ;");
        // bind value
        $this->db->bind(":username", $username);
        // execute and get row
        $row = $this->db->resultRow();

        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    /**
     * @method FindUserbyEmail;
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
    public function findUserByEmail($email){
        // prepare statement
        $this->db->query("SELECT * FROM users WHERE email = :email ;");
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

    /**
     * @method FindUserbyLogin;
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
    public function findUserByLogin($login){
        // prepare statement
        $this->db->query("SELECT * FROM users WHERE username = :login OR email = :login ;");
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

    public function findUserById($id){
        // prepare statement
        $this->db->query("SELECT * FROM users WHERE id = :id ;");
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

    public function updateProfile($user){
        $sql = "UPDATE users SET 
                    firstname = :firstname, 
                    lastname = :lastname, 
                    city = :city,
                    age = :age, 
                    gender = :gender 
                    WHERE users.id = :id";

        $this->db->query($sql);
        $this->db->bind(":firstname",$user['firstname']);
        $this->db->bind(":lastname",$user['lastname']);
        $this->db->bind(":city",$user['city']);
        $this->db->bind(":age",$user['age']);
        $this->db->bind(":gender",$user['gender']);
        $this->db->bind(":id",$_SESSION['id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    // upload image path
    public function uploadImagePath($path){
        $sql = "UPDATE users SET image = :image WHERE users.id = :id";
        $this->db->query($sql);
        $this->db->bind(':image', $path);
        $this->db->bind(':id', $_SESSION['id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    // update user secret
    public function updateSecret($newSecret, $id){
       $newSecret = password_hash($newSecret, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET secret = :secret WHERE users.id = :id";

        $this->db->query($sql);
        $this->db->bind(":secret", $newSecret);
        $this->db->bind(":id", $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    // update Email adress
    public function updateEmail($newEmail){

        $sql = "UPDATE users SET email = :email WHERE users.id = :id";

        $this->db->query($sql);
        $this->db->bind(":email", $newEmail);
        $this->db->bind(":id", $_SESSION['id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function setToken($email, $token){
        $sql = "UPDATE users SET token = :token WHERE email = :email";

        $this->db->query($sql);
        $this->db->bind(":token", $token);
        $this->db->bind(":email", $email);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getToken($email, $token){
        $sql = "SELECT * FROM users WHERE email = :email AND token = :token";


        $this->db->query($sql);
        $this->db->bind(":token", $token);
        $this->db->bind(":email", $email);

        $row = $this->db->resultRow();

        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }

    }




}