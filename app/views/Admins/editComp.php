<?php
/**
 * inc/edit.php - Page where the user edits her profile
 *
 * @package    TurtleMVC-Core
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 * @uses bootstrap4
 */

require APPROOT . "/views/inc/header.php";
/** @var array $data */
$comp = $data['comp'];
?>
<div class="row mb-4">
    <div class="col">
        <h1>Wijzig de gegevens van: <?php echo $comp->comp_name ?></h1>
    </div>

</div>
<div class="row mb-3">
    <div class="col">
        <a href="<?php echo URLROOT . "Admins/dashboard/" . $_SESSION['comp_username'] ?>">
            <button type="button" class="btn btn-danger"><i class="fa fa-arrow-left">
                </i> Terug
            </button>
        </a>
    </div>
</div>
<div class="row">
    <div class="col">
        <form class="form-group" action="<?php echo URLROOT . "admins/editComp/" . $comp->comp_id ?>" method="post">
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="compname">Gebruikers naam </label>
                    <input type="text" class="form-control" name="compname"
                           value="<?php echo $comp->comp_name ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="city">Stad</label>
                    <input type="text" class="form-control" name="city"
                           value="<?php echo $comp->comp_city ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-warning">
                <i class="fa fa-pencil-square-o edit-icon-profile"></i>
                Wijzig
            </button>
        </form>
    </div>
</div>

<hr>

<?php require APPROOT . "/views/inc/footer.php" ?>
