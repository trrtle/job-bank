<?php
/**
* pages/index.php - placeholder index page
*
* @package    TurtleMVC-Core
* @license    https://opensource.org/licenses/BSD-3-Clause
* @author     Micky Aarnoudse
* @copyright  2020 Micky Aarnoudse
*/
?>
<?php

require APPROOT . "/views/inc/header.php"
/** @var array $data */
?>
<div class="jumbo-index-background">
    <div class="jumbotron jumbo-index text-center ">
        <h1 class="display-4">Power Jobs</h1>
        <p class="lead">Generieke slogan die helemaal nergens opslaat</p>
    </div>
</div>

<div class="row text-center">
    <div class="col-12">
        <h1 class="mb-4">Laatste vacatures</h1>
    </div>
</div>
<div class="row mb-3 card-deck text-center">
    <?php foreach ($data["latestOffers"] as $offers=>$offer): ?>
        <div class="card shadow-sm">
            <h5 class="card-header"><?php echo $offer->offer_title ?></h5>
            <div class="card-body">
                <p class="card-text"><?php echo substr($offer->offer_desc, 0, 200) ?>....</p>
                <a href="<?php echo URLROOT . "Offers/show/" . $offer->offer_id ?>" class="btn btn-block btn-outline-primary">Lees meer</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php require APPROOT . "/views/inc/footer.php"?>