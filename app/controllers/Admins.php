<?php


class Admins extends Controller
{

    private $adminModel;
    private $compModel;
    private $userModel;
    private $offerModel;
    private $invoiceModel;

    public function __construct()
    {
        $this->adminModel = $this->model("Admin");
        $this->compModel = $this->model("Company");
        $this->userModel = $this->model("User");
        $this->offerModel = $this->model("Offer");
        $this->invoiceModel = $this->model('Invoice');
    }

    public function index()
    {
        redirect("admins/dashboard");
    }

    // admin login
    public function login()
    {
        // check for POST
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // process form
            $data = [
                'username' => trim($_POST['username']),
                'secret' => $_POST['secret'],
                'username_err' => '',
                'secret_err' => '',
            ];

            // validate user input
            if (empty($data["username"])) {
                $data["username_err"] = "Please fill in your username";
            }
            if (empty($data["secret"])) {
                $data["secret_err"] = "Please fill in your password";
            }

            // check captcha
            if (!captcha($_POST['g-recaptcha-response'])) {

                // when captcha is not clicked load page with errors
                $data = [
                    'captcha_err' => 'Ben je een robot?'
                ];

                $this->view('Admins/login', $data);
            }

            // check if errors are empty
            if (empty($data['username_err']) && empty($data['secret_err']) && empty($data['captcha_err'])) {

                // try logging in
                $loggedInAdmin = $this->adminModel->login($data['username'], $data['secret']);

                if ($loggedInAdmin) {

                    $this->createAdminSession($loggedInAdmin);

                } else {

                    // if password or username is incorrect load login with errors.
                    $data['username_err'] = 'Credentials are incorrect';
                    $data['secret_err'] = 'Credentials are incorrect';
                    $this->view('/Admins/login', $data);
                }

            } else {
                // load page with erros
                $this->view("Admins/login", $data);
            }

        } else {
            // initialize form
            $data = [
                'username' => '',
                'secret' => '',
                'username_err' => '',
                'secret_err' => ''
            ];

            $this->view('Admins/login', $data);
        }

    }

    public function dashboard()
    {

        if (!admin_isLoggedIn()) {
            redirect("Pages/index");
            die();
        }

        $comps = $this->adminModel->getAllComps();
        $users = $this->adminModel->getAllUsers();
        $offers = $this->offerModel->getAlloffers();
        $comms = $this->invoiceModel->totalCommByOffer();

        $data = [
            'comps' => $comps,
            'users'=>$users,
            'offers'=>$offers,
            'comms'=>$comms
        ];
        $this->view('Admins/dashboard', $data);
    }

    public function delComp($id)
    {
        if (!admin_isLoggedIn()) {
            redirect("Pages/index");
        }

        if ($this->adminModel->delComp($id)) {
            $_SESSION['flash'] = new Flash("Werkgever is verwijderd");
            redirect("admins/dashboard");
        } else {
            $_SESSION['flash'] = new Flash("Kon werkgever niet verwijderen", "alert alert-danger");
            redirect("admins/dashboard");
        }
    }


    public function addComp()
    {
        if (!admin_isLoggedIn()) {
            redirect("Pages/index");
            die();
        }
        // check for POST
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // process form
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'secret' => $_POST['secret'],
                'secret_confirm' => $_POST['secret_confirm'],
                'comp-name' => $_POST['name'],
                'city' => $_POST['city'],
                'username_err' => '',
                'email_err' => '',
                'secret_err' => '',
                'secret_conf_err' => ''
            ];

            // validate user input
            if (empty($data["username"])) {
                $data["username_err"] = "Please fill in the username";
            } elseif ($this->compModel->findCompByName($data['username'])) {
                $data["username_err"] = "Username already exists";
            }

            if (empty($data["email"])) {
                $data["email_err"] = "Please fill in the company email address";
            } elseif ($this->compModel->findCompByEmail($data['email'])) {
                $data["email_err"] = "Email already exists";
            }

            if (empty($data["secret"])) {
                $data["secret_err"] = "Please fill your password";
            } elseif (strlen($data['secret']) < 6) {
                $data["secret_err"] = "Password should be atleast 6 characters";
            }
            if (empty($data["secret_confirm"])) {
                $data["secret_conf_err"] = "Please confirm your password";
            } elseif ($data['secret'] !== $data["secret_confirm"]) {
                $data["secret_conf_err"] = "Passwords do not match";
            }

            // check if errors are empty
            if (empty($data['username_err']) && empty($data['email_err'])
                && empty($data['secret_err']) && empty($data['secret_conf_err'])) {

                // Hash password
                $data['secret'] = password_hash($data['secret'], PASSWORD_DEFAULT);

                // Register user
                if ($this->compModel->registerComp($data)) {

                    registrationEmail($_POST['email'], $_POST['username']);
                    $_SESSION["flash"] = new Flash("Registration complete! 
                    Er is een mail gestuurd naar het geregistreerde adres");
                    redirect("Admins/Dashboard");


                } else {
                    die("Something went wrong");
                }

            } else {
                // load page with erros
                $this->view("Admins/addComp", $data);
            }

        } else {
            // initialize form
            $data = [
                'username' => '',
                'email' => '',
                'secret' => '',
                'secret-confirm' => '',
                'comp-name' => '',
                'city' => '',
                'username_err' => '',
                'email_err' => '',
                'secret_err' => '',
                'secret_conf_err' => ''
            ];

            $this->view("Admins/addComp", $data);
        }


    }

    public function editComp($id)
    {
        if (!admin_isLoggedIn()) {
            redirect("Pages/index");
            die();
        }

        // check for POST
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // process form
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'comp-name' => $_POST['name'],
                'city' => $_POST['city'],
                'id'=> $id,
                'username_err' => '',
                'email_err' => '',
            ];

            // validate user input
            if (empty($data["username"])) {
                $data["username_err"] = "Gebruikersnaam mag niet leeg zijn.";
            }
            // check if username belongs to another account
            $company = $this->compModel->findCompByName($data['username']);
            if ($company && $company->comp_id != $id) {
                $data["username_err"] = "Gebruikersnaam is al ingebruik";
            }


            if (empty($data["email"])) {
                $data["email_err"] = "Please fill in the company email address";
            }
            // check if email belongs to another account.
            $company = $this->compModel->findCompByEmail($data['email']);
            if ($company && $company->comp_id != $id) {
                $data["email_err"] = "Email already exists";
            }

            // check if errors are empty
            if (empty($data['username_err']) && empty($data['email_err'])) {

                // Register user
                if ($this->adminModel->editComp($data)) {

                    $_SESSION["flash"] = new Flash("Gegevens zijn gewijzigd.");
                    redirect("Admins/Dashboard");


                } else {
                    die("Something went wrong");
                }

            } else {
                // redirect with errors
                if(!empty($data['username_err'])){
                    $_SESSION["flash"] = new Flash("Gebruikersnaam mag niet leeg zijn of is al ingebruik",
                        "alert alert-danger");
                }elseif (!empty($data['email_err'])){
                    $_SESSION["flash"] = new Flash("Email mag niet leeg zijn of is al ingebruik",
                        "alert alert-danger");
                }
                redirect("Admins/Dashboard");
            }
        }
        $comp = $this->compModel->getCompById($id);

        $data = [
            'comp' => $comp
        ];

        $this->view("Admins/editComp", $data);
    }

    public function delUser($id){
        if (!admin_isLoggedIn()) {
            redirect("Pages/index");
            die();
        }

        if ($this->adminModel->delUser($id)) {
            $_SESSION['flash'] = new Flash("Sollicitant is verwijderd");
            redirect("admins/dashboard");
        } else {
            $_SESSION['flash'] = new Flash("Kon sollicitant niet verwijderen", "alert alert-danger");
            redirect("admins/dashboard");
        }

    }

    public function editUser($id)
    {
        if (!admin_isLoggedIn()) {
            redirect("Pages/index");
            die();
        }

        // check for POST
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // process form
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'id'=> $id,
                'username_err' => '',
                'email_err' => '',
            ];

            // validate user input
            if (empty($data["username"])) {
                $data["username_err"] = "Gebruikersnaam mag niet leeg zijn.";
            }
            // check if username belongs to another account
            $user = $this->userModel->findUserByUsername($data['username']);
            if ($user && $user->id != $id) {
                $data["username_err"] = "Gebruikersnaam is al ingebruik";
            }

            if (empty($data["email"])) {
                $data["email_err"] = "Please fill in the company email address";
            }
            // check if email belongs to another account.
            $user = $this->userModel->findUserByEmail($data['email']);
            if ($user && $user->id != $id) {
                $data["email_err"] = "Email already exists";
            }

            // check if errors are empty
            if (empty($data['username_err']) && empty($data['email_err'])) {

                // Register user
                if ($this->adminModel->editUser($data)) {

                    $_SESSION["flash"] = new Flash("Gegevens zijn gewijzigd.");
                    redirect("Admins/Dashboard");


                } else {
                    die("Something went wrong");
                }

            } else {
                // redirect with errors
                if(!empty($data['username_err'])){
                    $_SESSION["flash"] = new Flash("Gebruikersnaam mag niet leeg zijn of is al ingebruik",
                        "alert alert-danger");
                }elseif (!empty($data['email_err'])){
                    $_SESSION["flash"] = new Flash("Email mag niet leeg zijn of is al ingebruik",
                        "alert alert-danger");
                }
                redirect("Admins/Dashboard");
            }
        }
        $user = $this->userModel->findUserById($id);

        $data = [
            'user'=>$user
        ];

        $this->view("Admins/editUser", $data);
    }


    public function delInvoice($offer_id){

        if (!admin_isLoggedIn()) {
            redirect("Pages/index");
            die();
        }

        if ($this->invoiceModel->deleteInvoice($offer_id)) {
            $_SESSION['flash'] = new Flash("Factuur is verwijderd");
            redirect("admins/dashboard");
        } else {
            $_SESSION['flash'] = new Flash("Kon Factuur niet verwijderen", "alert alert-danger");
            redirect("admins/dashboard");
        }

    }

    public function createAdminSession($admin)
    {
        $_SESSION['admin_id'] = $admin->id;
        $_SESSION['username'] = $admin->username;
        redirect('Admins/dashboard');
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['username']);
        redirect("Pages/index");
    }
}