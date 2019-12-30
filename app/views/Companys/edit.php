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

require APPROOT . "/views/inc/header.php"
/** @var array $data */
?>
    <div class="card bg-white">
        <div class="card-header">
            <h1>Wijzig je profiel</h1>
        </div>
        <div class="card-body">
        <form class="form-group" action="<?php echo URLROOT ?>companys/edit" method="post">
            <h4>Gegevens</h4>
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <label for="compname">Weertegeven naam</label>
                <input type="text" class="form-control" name="compname" value="<?php echo $data['company']->comp_name?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <label for="city">Stad</label>
                <input type="text" class="form-control" name="city" value="<?php echo $data['company']->comp_city?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-pencil-square-o edit-icon-profile"></i>
            Wijzig
        </button>
    </form>

    <hr>

    <form class="form-group" action="<?php echo URLROOT?>Companys/uploadImage" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col">
                <label for="image"><h4>Afbeelding</h4></label>
                <input type="file" class="form-control-file" name="image">
                <small><i>max 2 mb.</i></small>
            </div>
        </div>
            <div class="row mb-3">
                <div class="col">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-cloud-upload"></i>
                        Upload
                    </button>
                </div>
                <div class="col offset-sm-4 offset-md-6 offset-lg-8">
                    <a href="<?php echo URLROOT . "companys/profile/" . $_SESSION["comp_username"]?>">
                        <button type="button" class="btn btn-danger">
                            <i class="fa fa-undo"></i>
                            Annuleer
                        </button>
                    </a>
                </div>
            </div>
    </form>
    </div>
    </div>

<?php require APPROOT . "/views/inc/footer.php"?>