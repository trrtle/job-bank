<?php

class Offers extends Controller{

    private $offerModel;
    private $compModel;

    public function __construct()
    {   // redirect if user is not logged in
        if(!comp_isLoggedIn()){
            redirect("Pages/index");
        }

        // set current model
        $this->offerModel = $this->model("Offer");
        $this->compModel = $this->model("Company");
    }

    //default
    public function index(){

        $data = [

        ];

        $this->view('Pages/index', $data);
    }


    public function dashboard(){
        $result = $this->offerModel->getAllOffersByCompId($_SESSION['comp_id']);
        $data = [
            'offers'=>$result
        ];

        $this->view('Offers/dashboard', $data);
    }

    public function show($offer_id = ''){

        // if no id is given return to overview
        if(!empty($offer_id)){

            // get offer from database
            $offer = $this->offerModel->getOfferById($offer_id);

            // get company by id
            $comp = $this->compModel->getCompById($offer->comp_id);

            //if there is a result show view else return to overview
            if (!empty($offer)){
                $data = [
                    'offer'=>$offer,
                    'comp'=>$comp
                ];

                $this->view('Offers/show', $data);
            }else{
                $this->dashboard();
            }



        }else {
            $this->dashboard();
        }





    }
}
