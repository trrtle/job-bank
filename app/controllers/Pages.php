<?php
/**
 * controllers/Pages.php - Pages controller loads the generic pages.
 *
 * @package    TurtleMVC-Core
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 */

class Pages extends Controller{

    private $offerModel;

    public function __construct(){
        $this->offerModel = $this->model("Offer");
    }

    public function index(){

        $latestOffers = $this->offerModel->getLatestOffers(3);

        $data = [
            "latestOffers"=>$latestOffers
        ];
        $this->view('/Pages/index', $data);
    }

    public function about(){
        $data = [
            "title"=>"About us"
        ];
        $this->view('/Pages/about', $data);
    }
}