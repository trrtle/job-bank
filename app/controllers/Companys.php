<?php

class Companys extends Controller{

    private $compModel;

    public function __construct(){
        $this->compModel = $this->model("Company");
    }

    public function index(){
        if(!comp_isLoggedIn()){
            redirect("Pages/index");
        }

        $data = [

        ];
        $this->view('Companys/index', $data);
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

    // company account settings
    public function settings(){

        // check if company is logged in
        if(!isset($_SESSION["comp_id"]) && !isset($_SESSION['comp_username'])){
            redirect("companys/login");
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
            $comp = $this->compModel->findCompById($id);

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
        redirect('Companys/index');
    }
}