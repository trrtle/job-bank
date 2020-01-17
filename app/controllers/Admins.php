<?php


class Admins extends Controller{

    private $adminModel;
    public function __construct()
    {
        $this->adminModel = $this->model("Admin");
    }

    // admin login
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
                $data["username_err"] = "Please fill in your username";
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

                $this->view('Admins/login', $data);
            }

            // check if errors are empty
            if(empty($data['username_err']) && empty($data['secret_err']) && empty($data['captcha_err'])){

                // try logging in
                $loggedInAdmin = $this->adminModel->login($data['username'], $data['secret']);

                if($loggedInAdmin){

                    $this->createAdminSession($loggedInAdmin);

                }else{

                    // if password or username is incorrect load login with errors.
                    $data['username_err'] = 'Credentials are incorrect';
                    $data['secret_err'] = 'Credentials are incorrect';
                    $this->view('/Admins/login', $data);
                }

            }else{
                // load page with erros
                $this->view("Admins/login", $data);
            }

        }else{
            // initialize form
            $data =[
                'username'=>'',
                'secret'=>'',
                'username_err'=>'',
                'secret_err'=>''
            ];

            $this->view('Admins/login', $data);
        }

    }

    public function dashboard(){

        if(!admin_isLoggedIn()){
            redirect("Pages/index");
        }

//        $user = $this->userModel->findUserById($_SESSION['id']);
//        $latestOffers = $this->offerModel->getLatestOffers(3);
//        $resps = $this->respModel->getAllRespsByUserId($_SESSION['id']);

        $data = [

        ];
        $this->view('Admins/dashboard', $data);
    }

    public function createAdminSession($admin){
        $_SESSION['admin_id'] = $admin->id;
        $_SESSION['username'] = $admin->username;
        redirect('Admins/dashboard');
    }
}