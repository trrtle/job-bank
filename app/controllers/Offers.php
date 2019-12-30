<?php

class Offers extends Controller{

    private $offerModel;

    public function __construct()
    {   // redirect if user is not logged in
        if(!comp_isLoggedIn()){
            redirect("Pages/index");
        }

        // set current model
        $this->offerModel = $this->model("Offer");
    }

    //default
    public function index(){

        $data = [

        ];

        $this->view('Pages/index', $data);
    }


    public function overview(){
        $result = $this->offerModel->getAllOffersByCompId($_SESSION['comp_id']);

        $data = [
            'offers'=>$result
        ];

        $this->view('Offers/overview', $data);
    }
}
