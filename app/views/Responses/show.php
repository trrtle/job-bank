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
<small><i>Geplaatst door: <a href=" <?php echo URLROOT . "Users/profile/" . $data['resp']->username; ?>">
            <?php echo (!empty($data['resp']->firstname) ? $data['resp']->firstname . " " . $data['resp']->lastname : $data['resp']->username); ?>
        </a></i></small>

<?php require APPROOT . "/views/inc/footer.php"?>



