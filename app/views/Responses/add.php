<?php
require APPROOT . "/views/inc/header.php";
/** @var array $data */
?>

<div class="row mb-5">
    <div class="col">
        <h1>Reageren op de vacature <?php echo $data['offer']->offer_id ?></h1>
    </div>
</div>
<form>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php print_r($data['post'])?>
<?php require APPROOT . "/views/inc/footer.php" ?>