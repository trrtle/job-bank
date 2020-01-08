<?php
require APPROOT . "/views/inc/header.php";
/** @var array $data */
?>

<div class="row mb-5">
    <div class="col">
        <h1>Reageren op de vacature: <?php echo $data['offer']->offer_title ?></h1>
    </div>
</div>
<form action="<?php echo URLROOT . "Responses/add/" . $data["offer"]->offer_id?>" method="POST">
    <div class="form-group">
        <label for="response_text">
            Vertel iets over jezelf en je motivatie
        </label>
<textarea name="response_text"
          class="form-control <?php echo (!empty($data['text_err'])) ? 'is-invalid' : ''; ?>"
          rows="5">
</textarea>
        <span class="invalid-feedback"><?php echo $data['text_err']; ?></span>
    </div>
    <button type="submit" class="btn btn-success">Versturen</button>
</form>
<?php print_r($data['post'])?>
<?php require APPROOT . "/views/inc/footer.php" ?>