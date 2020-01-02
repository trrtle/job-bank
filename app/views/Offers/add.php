<?php
/**
 * Company/add.php
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
<div class="row mb-4">
    <h1>Nieuwe vacature</h1>
</div>
<div class="row mb-3">
    <a href="<?php echo URLROOT . "Offers/dashboard" ?>">
        <button type="button" class="btn btn-danger"><i class="fa fa-arrow-left">
            </i> Terug</button>
    </a>
</div>
<div class="row row-fluid">
    <div class="col-12">
        <form action="<?php echo URLROOT?>Offers/add" method="post"">
        <div class="form-group">
            <label for="offer_title"><strong>Titel</strong></label>
            <input type="text" class="form-control
            <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" name="offer_title">
            <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
        </div>
        <div class="form-group">
            <label for="offer_tags"><strong>Tags</strong></label>
            <input type="text" class="form-control <?php echo (!empty($data['tags_err'])) ? 'is-invalid' : ''; ?>"
                   name="offer_tags" placeholder="voorbeeld: web developer ict">
            <span class="invalid-feedback"><?php echo $data['tags_err']; ?></span>
            <small><i>Tags zijn woorden waarmee de vacature gevonden kan worden</i></small>
        </div>
        <div class="form-group">
            <label for="offer_desc"><strong>Beschrijving</strong></label>
            <textarea class="form-control <?php echo (!empty($data['desc_err'])) ? 'is-invalid' : ''; ?>"
                      name="offer_desc" rows="10"></textarea>
            <span class="invalid-feedback"><?php echo $data['desc_err']; ?></span>
        </div>
        <button type="submit" class="btn btn-success">Plaatsen</button>
        </form>
    </div>

</div>
<?php require APPROOT . "/views/inc/footer.php" ?>
