<?php

class Responses extends Controller{

    private $db;
    private $offerModel;
    private $respModel;
    private $invoiceModel;

    public function __construct(){
        $this->db = new Database();
        $this->offerModel = $this->model("Offer");
        $this->respModel = $this->model("Response");
        $this->invoiceModel = $this->model("Invoice");

        if(!isLoggedIn()){
            redirect("Users/login");
        }
    }

    public function add($offer_id = ''){

        if (empty($offer_id)){
            redirect("Pages/index");
        }

        if(comp_isLoggedIn()){
            redirect("offers/show/" . $offer_id);
            $_SESSION['flash'] = new Flash('Als bedrijf kun je niet reageren op een vacature',
                'alert alert-danger');
        }

        $offer = $this->offerModel->getOfferById($offer_id);

        // check for POST
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // check if user already responded
            $respExists = $this->respModel->checkRespsByUserIdOnOffer($_SESSION['id'], $offer_id);
            if(!empty($respExists)){
                redirect("offers/show/" . $offer_id);
                $_SESSION['flash'] = new Flash('Je kunt maar 1 keer reageren op een vacature.', "alert alert-danger");
                die();
            }

            if(empty($_POST["resp_text"])){

                $data = [
                    "text_err"=>"Veld mag niet leeg zijn",
                    'offer'=>$offer
                ];


                $this->view("Responses/add", $data);
            }else{
                $data = [
                    'offer'=>$offer
                ];

                if($this->respModel->addResponse($offer_id, $_POST['resp_text'], $_SESSION['id'])){

                   // add an invoice for the response
                    $resp = $this->respModel->checkRespsByUserIdOnOffer($_SESSION['id'], $offer_id);
                    $this->invoiceModel->insertInvoice($resp->resp_id, $offer_id, $_SESSION['id']);

                    redirect("offers/show/" . $offer_id);
                    $_SESSION['flash'] = new Flash('Reactie is verstuurd!');

                }else{
                    redirect("offers/show/" . $offer_id);
                    $_SESSION['flash'] = new Flash('Er is iets fout gegaan.', 'alert alert-danger');
                }
            }


        }else{

            $data =[
            'text_err'=>'',
            'offer'=>$offer
            ];

            $this->view("Responses/add" , $data);
        }

    }

    public function show($resp_id){

        $resp = $this->respModel->getRespById($resp_id);

        $data =[

            'resp'=>$resp
        ];

        $this->view("Responses/show" , $data);
    }

}