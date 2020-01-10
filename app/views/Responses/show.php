<?php

require APPROOT . "/views/inc/header.php";
/** @var array $data */
?>
<div class="row mb-5">
    <div class="col">
        <h1>Reactie op vacature: <?php  echo $data['resp']->offer_title ?></h1>
    </div>
</div>
<div class="row mb-5">
    <div class="col">
        <p><?php echo $data['resp']->resp_text?></p>
    </div>
</div>
<hr>

<?php require APPROOT . "/views/inc/footer.php"?>



