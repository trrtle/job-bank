<?php

class Offers extends Controller{

    private $offerModel;
    private $compModel;
    private $respModel;
    private $invoiceModel;

    public function __construct()
    {

        // set current model
        $this->offerModel = $this->model("Offer");
        $this->compModel = $this->model("Company");
        $this->respModel = $this->model("Response");
        $this->invoiceModel = $this->model('Invoice');
    }

    //default
    public function index(){

        redirect("Companys/dashboard");
    }


    public function show($offer_id = ''){

        // redirect if user is not logged in
        if(comp_isLoggedIn() || isLoggedIn()){

            // if no id is given return to overview
            if(!empty($offer_id)){

                // get offer from database
                $offer = $this->offerModel->getOfferById($offer_id);

                // get company by id
                $comp = $this->compModel->getCompById($offer->comp_id);

                if (empty($comp)){
                    redirect("Pages/index");
                }

                //if there is a result show view else return to overview
                if (!empty($offer)){
                    $data = [
                        'offer'=>$offer,
                        'comp'=>$comp
                    ];

                    $this->view('Offers/show', $data);
                }else{
                    $this->index();
                }

            }else {
                $this->index();
            }
        }else{
            redirect("Users/login");
        }

    }

    public function showAll(){

        $offers = $this->offerModel->getAllOffers();
        $data  =[
            'offers'=>$offers
        ];

        $this->view("Offers/showall", $data);
    }

    public function add(){

        // redirect if user is not logged in
        if(!comp_isLoggedIn()){
            redirect("Pages/index");
        }

        // check for POST
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // proces form
            $data = [
                'offer_title'=>$_POST['offer_title'],
                'offer_desc'=>$_POST['offer_desc'],
                'offer_tags'=>$_POST['offer_tags'],
                'title_err'=>'',
                'desc_err'=>'',
                'tags_err'=>''
            ];

            // validate user input
            if(empty($data["offer_title"])){
                $data["title_err"] = "Vul een titel in";
            }

            if(empty($data["offer_desc"])){
                $data["desc_err"] = "Vul beschrijving in";
            }

            if(empty($data["offer_tags"])){
                $data["tags_err"] = "Vul minimaal 1 tag in";
            }

            // check if errors are empty
            if(empty($data['title_err']) && empty($data['desc_err']) && empty($data['tags_err'])){
                // add vacature
                if($this->offerModel->addOffer($data['offer_title'], $data['offer_desc'], $data['offer_tags'])){
                    redirect('Companys/dashboard');
                    $_SESSION['flash'] = new Flash("Vacature toegevoegd");
                }else{
                    redirect('Offers/add');
                    $_SESSION['flash'] = new Flash("Er is iets fout gegaan", "alert alert-danger");
                }
            }else{
                // Load view with errors
                $this->view("Offers/add", $data);
            }


        }else {

            // initialize form
            $data = [
                'offer_title'=>'',
                'offer_desc'=>'',
                'offer_tags'=>'',
                'title_err'=>'',
                'desc_err'=>'',
                'tags_err'=>''
            ];

            $this->view("Offers/add", $data);
        }

    }

    public function edit($offer_id){

        // redirect if user is not logged in
        if(!comp_isLoggedIn()){
            redirect("Pages/index");
        }

        //get offer from database
        $offer = $this->offerModel->getOfferById($offer_id);

        // if offer is not from the logged in company redirect to dashboard
        if($offer->comp_id != $_SESSION["comp_id"]){
            redirect('Companys/dashboard');
        }

        // check for POST
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // proces form
            $data = [
                'offer_title'=>$_POST['offer_title'],
                'offer_desc'=>$_POST['offer_desc'],
                'offer_tags'=>$_POST['offer_tags'],
                'title_err'=>'',
                'desc_err'=>'',
                'tags_err'=>''
            ];

            // validate user input
            if(empty($data["offer_title"])){
                $data["title_err"] = "Vul een titel in";
            }

            if(empty($data["offer_desc"])){
                $data["desc_err"] = "Vul beschrijving in";
            }

            if(empty($data["offer_tags"])){
                $data["tags_err"] = "Vul minimaal 1 tag in";
            }

            // check if errors are empty
            if(empty($data['title_err']) && empty($data['desc_err']) && empty($data['tags_err'])){
                // update offer
                if($this->offerModel->updateOffer($offer_id, $_POST['offer_title'], $_POST['offer_desc'], $_POST['offer_tags'])){
                    redirect('Companys/dashboard');
                    $_SESSION['flash'] = new Flash("Vacature is gewijzigd");
                }else{
                    redirect('Companys/dashboard');
                    $_SESSION['flash'] = new Flash("Er is iets fout gegaan", "alert alert-danger");
                }
            }
            else{
                redirect('Companys/dashboard');
                $_SESSION['flash'] = new Flash("Vacature niet gewijzigd, velden mogen niet leeg zijn!", "alert alert-danger");
            }


        }else {


            // initialize form
            $data = [
                'offer_title'=>$offer->offer_title,
                'offer_desc'=>$offer->offer_desc,
                'offer_tags'=>$offer->offer_tags,
                'offer_id'=>$offer->offer_id,
                'title_err'=>'',
                'desc_err'=>'',
                'tags_err'=>''
            ];

            $this->view("Offers/edit", $data);
        }
    }

    public function delete($offer_id){

        // redirect if user is not logged in
        if(!comp_isLoggedIn()){
            redirect("Pages/index");
        }

        //get offer from database
        $offer = $this->offerModel->getOfferById($offer_id);

        // if offer is not from the logged in company redirect to dashboard
        if($offer->comp_id != $_SESSION["comp_id"]){
            redirect('Offers/dashboard');
        }

        if($this->offerModel->deleteOffer($offer_id)){
            // remove responses
            $resps = $this->respModel->getRespsByOffer($offer_id);

            foreach($resps as $resp){
                $this->respModel->deleteResp($resp->resp_id);
            }

            redirect('Companys/dashboard');
            $_SESSION['flash'] = new Flash("Vacature is verwijderd");
        }

    }

    public function showResponses($offer_id = ''){

        // redirect if user is not logged in
        if(!comp_isLoggedIn() && !admin_isLoggedIn()){
            redirect("Pages/index");
        }

        if(empty($offer_id)){
            redirect("Pages/index");
        }


        $resps = $this->respModel->getRespsByOffer($offer_id);
        $offer = $this->offerModel->getOfferById($offer_id);
        $commCount = $this->invoiceModel->countCommissionByOffer($offer_id);
        settype($commCount, "integer");

        $data = [
            'resps'=>$resps,
            'offer'=>$offer,
            'commCount'=>$commCount
        ];

        $this->view("Offers/showresponses", $data);
    }
}
