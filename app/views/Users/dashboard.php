<?php
/**
 * users/dashboard.php
 *
 * @package    TurtleMVC-Core
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 * @uses bootstrap4
 */

require APPROOT . "/views/inc/header.php";
/** @var array $data */
?>
<div class="row mb-5">
    <div class="col">
<h1>Welkom <?php echo ucwords($_SESSION['username']) ?></h1>
    </div>
</div>
<div class="row">
    <div class="col">
        <h2 class="mb-3">Nieuwste Vacatures</h2>
    </div>
</div>
<div class="row mb-3 card-deck text-center">
    <?php foreach ($data["latestOffers"] as $offers=>$offer): ?>
        <div class="card mb-4 shadow-sm">
            <h5 class="card-header"><?php echo $offer->offer_title ?></h5>
            <div class="card-body d-flex flex-column ">
                <p class="card-text"><?php echo substr($offer->offer_desc, 0, 200) ?>....</p>
                <a href="<?php echo URLROOT . "Offers/show/" . $offer->offer_id ?>" class="btn btn-block btn-outline-primary mt-auto">Lees meer</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <div class="col">
        <button class="btn btn-primary btn-lg">Alle vacatures</button>
    </div>
</div>
<div class="row


<?php require APPROOT . "/views/inc/footer.php"?>


