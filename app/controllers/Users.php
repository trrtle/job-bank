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
        private $offerModel;

    public function __construct(){
        $this->userModel = $this->model("User");
        $this->offerModel = $this->model("Offer");
        $this->respModel = $this->model("Response");
    }

    // default page
    public function index(){

        $this->dashboard();
    }

    public function dashboard(){

        if(!user_isLoggedIn()){
            redirect("users/login");
        }

        $user = $this->userModel->findUserById($_SESSION['id']);
        $latestOffers = $this->offerModel->getLatestOffers(3);
        $resps = $this->respModel->getAllRespsByUserId($_SESSION['id']);

        $data = [
            'user'=>$user,
            'latestOffers'=> $latestOffers,
            'resps'=>$resps
        ];
        $this->view('Users/dashboard', $data);
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

            // check captcha
            if(!captcha($_POST['g-recaptcha-response'])){

                // when captcha is not clicked load page with errors
                $data['captcha_err'] ='Ben je een robot?';

                $this->view('/Users/register', $data);
            }

            // check if errors are empty
            if(empty($data['username_err']) && empty($data['email_err'])
                && empty($data['secret_err']) && empty($data['secret_confirm_err'])
                && empty($data['captcha_err'])){

                // Hash password
                $data['secret'] = password_hash($data['secret'], PASSWORD_DEFAULT);

                // Register user
                if($this->userModel->registerUser($data)){

                    registrationEmail($_POST['email'], $_POST['username']);
                    $_SESSION["flash"] = new Flash("Registration complete! 
                    Er is een mail gestuurd naar het geregistreerde adres");
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

            // check captcha
            if(!captcha($_POST['g-recaptcha-response'])){

                // when captcha is not clicked load page with errors
                $data = [
                    'captcha_err'=>'Ben je een robot?'
                ];

                $this->view('/Users/login', $data);
            }

            // check if errors are empty
            if(empty($data['username_err']) && empty($data['secret_err']) && empty($data['captcha_err'])){

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
                'secret_err'=>''
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
                'lastname' => trim($_POST['lastname']),
                'city' => trim($_POST['city']),
                'age' => $_POST['age'],
                'gender' => $_POST['gender']
            ];

            if($this->userModel->updateProfile($user)){
                $_SESSION["flash"] = new Flash("Profiel gewijzigd!");
                redirect("Users/profile/". $_SESSION["username"]);
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

                // check file size is les then 2mb
                if ($_FILES["image"]["size"] < 2000000) {

                    // set target
                    $target_dir = "img/";
                    $target_file = $target_dir . $_SESSION['username'] .".avatar";

                    // move the uploaded file to target
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $this->userModel->uploadImagePath($target_file);
                        redirect("Users/profile/" . $_SESSION["username"]);

                    } else {
                        redirect("Users/edit");;
                    }

                }else{
                    $_SESSION['flash'] = new Flash("File size is to big", "alert alert-danger");
                    redirect("Users/profile/" . $_SESSION["username"]);
                }

            }else{
                $_SESSION['flash'] = new Flash("Is not an image!", "alert alert-danger");
                redirect("Users/profile/" . $_SESSION["username"]);
            }

        }else{
            $_SESSION['flash'] = new Flash("Something went wrong", "alert alert-danger");
           redirect("Users/profile/" . $_SESSION["username"]);
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
                    if($this->userModel->updateSecret($data['secret'], $_SESSION['id'])){
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

    public function passwordRecovery(){
        // check for POST
        if($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $email = $_POST['email'];

            if(!$this->userModel->findUserByEmail($email)){
                $data = [
                    'email_err'=>'Gebruiker bestaat niet.',
                    'email'=>$email
                ];

                $this->view("Users/passwordRecovery", $data);
            }

            // Generate a token
            $token = bin2hex(random_bytes(32));
            $timestamp = new DateTime("now");
            $timestamp = $timestamp->getTimestamp();
            $token = $token . "timestamp" . $timestamp;

            // set token
            if($this->userModel->setToken($email, $token)){

                // Create URL
                $url = URLROOT . "users/passwordReset/";
                $url = $url . "token=" . $token;

                // create email.
                $subject = "Wachtwoord resetten";
                $message = "<p>U heeft zo juist een wachtwoord recovery aangevraagd.
                            klik op deze link: <a href='$url'>Password recovery</a> om uw wachtwoord te resetten.</p>";
                // send mail with url
                mailer($email, "Gebruiker", $subject, $message);


                $_SESSION['flash'] = new Flash("Er is een recovery mail gestuurd naar het opgegeven adres");
                redirect("Users/login");
            }else{
                $_SESSION['flash'] = new Flash("Er is iets fout gegaan", "alert alert-danger");
                redirect("Users/login");
            }

        }

        $data = [

        ];

        $this->view("Users/passwordRecovery", $data);
    }

    public function passwordReset($token = ''){

        // check for POST
        if($_SERVER["REQUEST_METHOD"] == 'POST') {



            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // form checks
            if(empty($_POST['email'])){
                $_SESSION['flash'] = new Flash("Onjuiste aanvraag: velden mogen niet leeg zijn",
                    'alert alert-danger');
                redirect("Users/login");
                exit();
            }

            if(empty($_POST["secret"])){
                $_SESSION['flash'] = new Flash("Onjuiste aanvraag: velden mogen niet leeg zijn", 'alert alert-danger');
                redirect("Users/login");
                exit();
            }elseif (strlen($_POST['secret']) < 6 ){
                $_SESSION['flash'] = new Flash("Onjuiste aanvraag: wachtwoord moet minmaal 6 characters lang zijn",
                    'alert alert-danger');
                redirect("Users/login");
                exit();
            }

            if(empty($_POST["secret_confirm"])){
                $_SESSION['flash'] = new Flash("Onjuiste aanvraag: velden mogen niet leeg zijn",
                    'alert alert-danger');
                redirect("Users/login");
                exit();
            }elseif ($_POST['secret'] !== $_POST["secret_confirm"]){
                $_SESSION['flash'] = new Flash("Onjuiste aanvraag: wachtwoorden zijn niet gelijk",
                    'alert alert-danger');
                redirect("Users/login");
                exit();
            }

            // check if token is in url
            if(!empty($token)){
                $token = str_replace("token=", "", $token);
                $email = $_POST['email'];

                // haal timestamp uit de url.
                $index = strpos($token, 'timestamp') + strlen('timestamp');
                $timestamp1 = substr($token, $index);

                // check of token niet is verouderd
                $timestamp2 = new DateTime("now");
                $timestamp2 = $timestamp2->getTimestamp();
                $timestamp = $timestamp2 - $timestamp1;

                if ($timestamp2 - $timestamp1 > 3600) { // if timestamp is greater then a hour.
                    $_SESSION['flash'] = new Flash("Aanvraag is verlopen", 'alert alert-danger');
                    redirect('Users/login');
                }

                // get token from db
                $row = $this->userModel->getToken($email, $token);

                if(!empty($row)){

                    // update nieuwe wachtwoord.
                    if($this->userModel->updateSecret($_POST["secret"], $row->id)){
                        $_SESSION['flash'] = new Flash("Wachtwoord is aangepast");
                        redirect("Users/login");
                    }else{
                        $_SESSION['flash'] = new Flash("Onjuiste aanvraag", 'alert alert-danger');
                        redirect('Users/login');
                        exit();
                    }

                }else{

                    $_SESSION['flash'] = new Flash("ongeldige aanvraag", 'alert alert-danger');
                    redirect('Users/login');
                    exit();
                }

            }else{ // if token is empty

                $_SESSION['flash'] = new Flash("Geen geldige aanvraag.", 'alert alert-danger');
                redirect('Users/login');
                exit();
            }

        }else{ // if not post request


            $data = [
                'token'=>$token
            ];

            $this->view("Users/passwordReset", $data);
        }


    }


    public function createUserSession($user){
        $_SESSION['id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['username'] = $user->username;
        $_SESSION['POST'] = $_POST;
        redirect('Users/dashboard');
    }

    public function logout(){
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        unset($_SESSION['username']);
        redirect("Users/login");
    }

}