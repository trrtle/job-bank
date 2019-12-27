<?php
/**
 * controllers/Users.php - Handles User related logic.
 *
 * @package    TurtleMVC-Addons
 * @subpackage TurtleMVC-Users
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 */


// always use plurals for controllers
class Users extends Controller {

        private $userModel;

    public function __construct(){
        $this->userModel = $this->model("User");
    }

    // default page
    public function index(){

        if(!isLoggedIn()){
            redirect("users/login");
        }

        $data = [

        ];
        $this->view('Users/index', $data);
    }

    // user registration
    public function register(){
        // check for POST
        if($_SERVER["REQUEST_METHOD"] == 'POST'){

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            // process form
            $data =[
                'username'=>trim($_POST["username"]),
                'email'=>trim($_POST["email"]),
                'secret'=>$_POST["secret"],
                'secret_confirm'=>$_POST["secret_confirm"],
                'username_err'=>'',
                'email_err'=>'',
                'secret_err'=>'',
                'secret_confirm_err'=>''
            ];

            // validate user input
            if(empty($data["username"])){
                $data["username_err"] = "Please fill in your username";
            }elseif ($this->userModel->findUserByUsername($data['username'])){
                $data["username_err"] = "Username already exists";
            }

            if(empty($data["email"])){
                $data["email_err"] = "Please fill in your email address";
            }elseif ($this->userModel->findUserByEmail($data['email'])){
                $data["email_err"] = "Email already exists";
            }

            if(empty($data["secret"])){
                $data["secret_err"] = "Please fill your password";
            }elseif (strlen($data['secret']) < 6 ){
                $data["secret_err"] = "Password should be atleast 6 characters";
            }
            if(empty($data["secret_confirm"])){
                $data["secret_confirm_err"] = "Please confirm your password";
            }elseif ($data['secret'] !== $data["secret_confirm"]){
                $data["secret_confirm_err"] = "Passwords do not match";
            }

            // check if errors are empty
            if(empty($data['username_err']) && empty($data['email_err'])
                && empty($data['secret_err']) && empty($data['secret_confirm_err'])){

                // Hash password
                $data['secret'] = password_hash($data['secret'], PASSWORD_DEFAULT);

                // Register user
                if($this->userModel->registerUser($data)){
                    $_SESSION["flash"] = new Flash("Registration complete!");
                    redirect("Users/login");
                }else{
                    die("Something went wrong");
                }

            }else{
                // load page with erros
                $this->view("Users/register", $data);
            }

        }else{
            // initialize form
            $data =[
                'username'=>'',
                'email'=>'',
                'secret'=>'',
                'secret_confirm'=>'',
                'username_err'=>'',
                'email_err'=>'',
                'secret_err'=>'',
                'secret_confirm_err'=>''
            ];

            $this->view('/Users/register', $data);
        }

    }

    // user login
    public function login(){
        // check for POST
        if($_SERVER["REQUEST_METHOD"] == 'POST'){

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // process form
            $data =[
                'username'=>trim($_POST['username']),
                'secret'=>$_POST['secret'],
                'username_err'=>'',
                'secret_err'=>'',
            ];

            // validate user input
            if(empty($data["username"])){
                $data["username_err"] = "Please fill in your username or email";
            }
            if(empty($data["secret"])){
                $data["secret_err"] = "Please fill in your password";
            }

            // check if errors are empty
            if(empty($data['username_err']) && empty($data['secret_err'])){

                // try logging in
                $loggedInUser = $this->userModel->login($data['username'], $data['secret']);

                if($loggedInUser){

                    $this->createUserSession($loggedInUser);

                }else{

                    // if password or username is incorrect load login with errors.
                    $data['username_err'] = 'Credentials are incorrect';
                    $data['secret_err'] = 'Credentials are incorrect';
                    $this->view('/Users/login', $data);
                }

            }else{
                // load page with erros
                $this->view("Users/login", $data);
            }

        }else{
            // initialize form
            $data =[
                'username'=>'',
                'secret'=>'',
                'username_err'=>'',
                'secret_err'=>'',
            ];

            $this->view('/Users/login', $data);
        }

    }

    // user profile
    public function profile($username = ''){

        // check if user is logged in
        if(!isLoggedIn()){
            redirect("users/login");
        }

        $user = $this->userModel->findUserByUsername($username);

        if(empty($user)){
            redirect("Pages/index");
        }

        $data = [
            'user'=>$user
        ];


        $this->view("/Users/profile", $data);
    }


    // Edit user profile
    public function edit(){

        // check if user is logged in
        if(!user_isLoggedIn()){
            redirect("users/login");
        }

        // check for POST
        if($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // process form
            $user = [
                'firstname' => trim($_POST['firstname']),
                'lastname' => $_POST['lastname'],
                'city' => $_POST['city'],
                'age' => $_POST['age'],
                'gender' => $_POST['gender']
            ];

            if($this->userModel->updateProfile($user)){
                $_SESSION["flash"] = new Flash("Profiel gewijzigd!");
                redirect("Users/profile");
            }else{
                die('something went wrong');
            }
        }

        // get logged-in user from database
        $username = $_SESSION['username'];

        // get row from the user
        $user = $this->userModel->findUserByUsername($username);

        $data = [
            'user'=>$user
        ];

        $this->view("/Users/edit", $data);
    }

    // upload image
    public function uploadImage(){

        // check if user is logged in
        if(!isset($_SESSION["id"]) && !isset($_SESSION['username'])){
            redirect("users/login");
        }

        // check if file is an image
        if(!empty($_FILES["image"]["tmp_name"])){
            $image = getimagesize($_FILES["image"]["tmp_name"]);

            if($image){

                // check file size is les then 5mb
                if ($_FILES["image"]["size"] < 5000000) {

                    // set target
                    $target_dir = "img/";
                    $target_file = $target_dir . $_SESSION['username'] .".avatar";

                    // move the uploaded file to target
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $this->userModel->uploadImagePath($target_file);
                        redirect("Users/profile");

                    } else {
                        die("Sorry, there was an error uploading your file.");
                    }

                }else{
                    $_SESSION['flash'] = new Flash("Image is to big", "alert alert-danger");
                    redirect("Users/edit");
                }

            }else{
                $_SESSION['flash'] = new Flash("Is not an image!", "alert alert-danger");
                redirect("Users/edit");
            }

        }else{
           redirect("Users/edit");
        }
    }


    // user account settings
    public function settings(){

        // check if user is logged in
        if(!isset($_SESSION["id"]) && !isset($_SESSION['username'])){
            redirect("users/login");
        }

        // check for POST
        if($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // if user updates email
            if(!empty($_POST['email'])){
                $data = [
                    'email'=>trim($_POST["email"]),
                    'email_err' =>''
                ];

                // check if email already exists
                if ($this->userModel->findUserByEmail($data['email'])){
                    $data["email_err"] = "Email already exists";
                    $_SESSION['flash'] = new Flash($data['email_err'], "alert alert-danger");
                    redirect("Users/settings");
                }

                // update email
                if($this->userModel->updateEmail($data['email'])){
                    $_SESSION['flash'] = new Flash("Email adres is aangepast!");
                    redirect("Users/settings");
                }else{
                    $_SESSION['flash'] = new Flash("Er is iets fout gegaan", "alert alert-danger");
                    redirect("Users/settings");
                }

            }  //if user updates password
            elseif(!empty($_POST['secret']) && !empty($_POST['secret_confirm'])){
                $data = [
                    'secret'=>$_POST["secret"],
                    'secret_confirm'=>$_POST["secret_confirm"],
                    'secret_err'=> '',
                    'secret_confirm_err'=>''
                ];

                // secret checks
                if (strlen($data['secret']) < 6 ){
                    $data["secret_err"] = "Password should be atleast 6 characters";
                    $_SESSION['flash'] = new Flash($data['secret_err'], "alert alert-danger");
                    redirect("Users/settings");
                }

                if ($data['secret'] !== $data["secret_confirm"]){
                    $data["secret_confirm_err"] = "Passwords do not match";
                    $_SESSION['flash'] = new Flash($data['secret_confirm_err'], "alert alert-danger");
                    redirect("Users/settings");
                }

                // check if errors are empty
                if(empty($data['secret_err']) && empty($data['secret_confirm_err'])){


                    // update secret
                    if($this->userModel->updateSecret($data['secret'])){
                        $_SESSION['flash'] = new Flash("Wachtwoord aangepast!");
                        redirect("Users/settings");
                    }else{
                        $_SESSION['flash'] = new Flash("Something went wrong!", "alert alert-danger");
                        redirect("Users/settings");
                    }

                }

            }

            // if input is empty
            elseif(empty($_POST['secret']) || empty($_POST['secret_confirm']) || empty($_POST['email'])){
                $_SESSION['flash'] = new Flash("Lege velden", "alert alert-danger");
                redirect("Users/settings");
            }

        // when request method is not POST
        }else{
            // get logged-in user from database
            $id = $_SESSION['id'];

            // get row from the user
            $user = $this->userModel->findUserById($id);

            $data = [
                'email'=>$user->email
            ];

            $this->view("Users/settings", $data );
        }

    }


    public function createUserSession($user){
        $_SESSION['id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['username'] = $user->username;
        redirect('Users/index');
    }

    public function logout(){
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        unset($_SESSION['username']);
        redirect("Users/login");
    }

}