<?php
require APPROOT . "/views/inc/header.php";
/** @var array $data */
?>
<div class="row mb-5">
    <div class="col">
        <h1>Vacatures</h1>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <h5>Filter</h5>
    </div>
</div>
<hr>
<?php foreach($data['offers'] as $offers=>$offer): ?>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title"><?php echo $offer->offer_title?></h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="<?php echo URLROOT . "Offers/show/" . $offer->offer_id ?>" class="card-link">Lees meer</a>
        </div>
    </div>

<?php endforeach; ?>
<?php require APPROOT . "/views/inc/footer.php" ?>
