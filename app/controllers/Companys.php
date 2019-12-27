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