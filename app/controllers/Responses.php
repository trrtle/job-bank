<?php

class Responses extends Controller{

    private $db;
    private $offerModel;
    private $respModel;

    public function __construct(){
        $this->db = new Database();
        $this->offerModel = $this->model("Offer");
        $this->respModel = $this->model("Response");

        if(!isLoggedIn()){
            redirect("Users/login");
        }
    }

    public function add($offer_id = ''){

        if (empty($offer_id)){
            redirect("Pages/index");
        }

        $offer = $this->offerModel->getOfferById($offer_id);

        // check for POST
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // Sanitize POST data. 1. call htmlspecialchars() on entire array. 2. set every value as a string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if(empty($_POST["response_text"])){

                $data = [
                    "text_err"=>"Veld mag niet leeg zijn",
                    'offer'=>$offer
                ];

                $this->view("Responses/add", $data);
            }



        }else{

            $data =[
            'text_err'=>'',
            'offer'=>$offer
            ];

            $this->view("Responses/add" , $data);
        }



    }

}