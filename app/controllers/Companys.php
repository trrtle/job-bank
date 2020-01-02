<?php

class Companys extends Controller{

    private $compModel;

    public function __construct(){
        $this->compModel = $this->model("Company");
    }

    //default
    public function index(){

        $data = [

        ];

        $this->view('Pages/index', $data);
    }


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
                $loggedInComp = $this->compModel->login($data['username'], $data['secret']);

                if($loggedInComp){

                    $this->createCompSession($loggedInComp);

                }else{

                    // if password or username is incorrect load login with errors.
                    $data['username_err'] = 'Credentials are incorrect';
                    $data['secret_err'] = 'Credentials are incorrect';
                    $this->view('/Companys/login', $data);
                }

            }else{
                // load page with erros
                $this->view("Companys/login", $data);
            }

        }else{
            // initialize form
            $data =[
                'username'=>'',
                'secret'=>'',
                'username_err'=>'',
                'secret_err'=>'',
            ];

            $this->view('/Companys/login', $data);
        }

    }

    // Company profile
    public function profile($comp_name = ''){

        // check if user is logged in
        if(!isLoggedIn()){
            redirect("users/login");
        }

        $company = $this->compModel->findCompByName($comp_name);

        if(empty($company)){
            redirect("Pages/index");
        }
        $data = [
            'company'=>$company
        ];

        $this->view("/Companys/profile", $data);

    }

    // Edit user profile
    public function edit(){

        // check if company is logged in
        if(!comp_isLoggedIn()){
            redirect("Pages/index");
        }

        // check for POST
        if($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // process form
            $company = [
                'comp_name' => trim($_POST['compname']),
                'comp_city' => $_POST['city'],
            ];

            if($this->compModel->updateProfile($company)){
                $_SESSION["flash"] = new Flash("Profiel gewijzigd!");
                redirect("Companys/profile/" . $_SESSION["comp_username"]);
            }else{
                die('something went wrong');
            }
        }

        // get logged-in user from database
        $company = $_SESSION['comp_username'];

        // get row from the user
        $company = $this->compModel->findCompByName($company);

        $data = [
            'company'=>$company
        ];

        $this->view("Companys/edit", $data);
    }

    // upload image
    public function uploadImage(){

        // check if company is logged in
        if(!comp_isLoggedIn()){
            redirect("Pages/index");
        }

        // check if file is an image
        if(!empty($_FILES["image"]["tmp_name"])){
            $image = getimagesize($_FILES["image"]["tmp_name"]);

            if($image){

                // check file size is les then 2mb
                if ($_FILES["image"]["size"] < 2000000) {

                    // set target
                    $target_dir = "img/";
                    $target_file = $target_dir . $_SESSION['comp_username'] .".avatar";

                    // move the uploaded file to target
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $this->compModel->uploadImagePath($target_file);
                        redirect("companys/profile/" . $_SESSION["comp_username"]);

                    } else {
                        die("Sorry, there was an error uploading your file.");
                    }

                }else{
                    $_SESSION['flash'] = new Flash("Image is to big", "alert alert-danger");
                    redirect("companys/profile/" . $_SESSION["comp_username"]);
                }

            }else{
                $_SESSION['flash'] = new Flash("Not an image", "alert alert-danger");
                redirect("companys/profile/" . $_SESSION["comp_username"]);
            }

        }
        else{
            $_SESSION['flash'] = new Flash("Something went wrong", "alert alert-danger");
            redirect("companys/profile/" . $_SESSION["comp_username"]);
        }
    }

    // company account settings
    public function settings(){

        // check if company is logged in
        if(!comp_isLoggedIn()){
            redirect("Pages/index");
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
                if ($this->compModel->findCompByEmail($data['email'])){
                    $data["email_err"] = "Email is al in gebruik";
                    $_SESSION['flash'] = new Flash($data['email_err'], "alert alert-danger");
                    redirect("Companys/settings");
                }

                // update email
                if($this->compModel->updateEmail($data['email'])){
                    $_SESSION['flash'] = new Flash("Email adres is aangepast!");
                    redirect("companys/settings");
                }else{
                    $_SESSION['flash'] = new Flash("Er is iets fout gegaan", "alert alert-danger");
                    redirect("companys/settings");
                }

            }  //if company updates password
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
                    redirect("Companys/settings");
                }

                if ($data['secret'] !== $data["secret_confirm"]){
                    $data["secret_confirm_err"] = "Passwords do not match";
                    $_SESSION['flash'] = new Flash($data['secret_confirm_err'], "alert alert-danger");
                    redirect("Companys/settings");
                }

                // check if errors are empty
                if(empty($data['secret_err']) && empty($data['secret_confirm_err'])){


                    // update secret
                    if($this->compModel->updateSecret($data['secret'])){
                        $_SESSION['flash'] = new Flash("Wachtwoord aangepast!");
                        redirect("Companys/settings");
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
            $id = $_SESSION['comp_id'];

            // get row from the user
            $comp = $this->compModel->getCompById($id);

            $data = [
                'email'=>$comp->comp_email
            ];

            $this->view("Companys/settings", $data );
        }

    }

    public function logout(){
        unset($_SESSION['comp_id']);
        unset($_SESSION['comp_email']);
        unset($_SESSION['comp_username']);
        redirect("Pages/index");
    }

    public function createCompSession($user){
        $_SESSION['comp_id'] = $user->comp_id;
        $_SESSION['comp_email'] = $user->comp_email;
        $_SESSION['comp_username'] = $user->comp_username;
        redirect('Offers/dashboard');
    }
}