<?php


class invoices extends Controller
{
    private $monthSalary;
    private $yearSalary;
    private $invoiceModel;
    private $offerModel;

    public function __construct()
    {
        $this->monthSalary = 20000;
        $this->yearSalary = $this->monthSalary * 12;

        $this->invoiceModel = $this->model("invoice");
        $this->offerModel = $this->model("offer");

    }

    public function createInvoice($comp_id){

        // krijg alle offer_id's van company
        $offers = $this->offerModel->getAllOffersByCompId($comp_id);

        // voor elke offer
        foreach($offers as $offer){
            // pak het distinct aantal reacties op de huidige offer
            $distinctResps = $this->invoiceModel->getRespsByOfferForInvoice($offer->offer_id);

            // check of er al een invoice bestaat op die reactie
            if($this->invoiceModel->getInvoice($distinctResps->resp_id, $distinctResps->offer_id, $distinctResps->user_id)){
                // skip the insert.
                continue;
            }else{
                // voer deze in de database
                $this->invoiceModel->insertInvoice($distinctResps->resp_id, $distinctResps->offer_id, $distinctResps->user_id);
            }

        }
    }
}
