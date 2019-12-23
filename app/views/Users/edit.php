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

<!--<div class="row mb-3">-->
<!--    <div class="card-header">-->
<!--        <h1>Wijzig je gegevens</h1>-->
<!--    </div>-->
<!--</div>-->

    <div class="card bg-white">
        <div class="card-header">
            <h1>Wijzig je gegevens</h1>
        </div>
        <div class="card-body">
        <form action="<?php echo URLROOT?>users/edit" method="post">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <label for="firstname">Voornaam</label>
                <input type="text" class="form-control" name="firstname" value="<?php echo $data['user']->firstname?>">
            </div>
            <div class="col-12 col-md-6">
                <label for="lastname">Achternaam</label>
                <input type="text" class="form-control" name="lastname" value="<?php echo $data['user']->lastname?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <label for="city">Woonplaats</label>
                <input type="text" class="form-control" name="city" value="<?php echo $data['user']->city?>">
            </div>
            <div class="col-6 col-md-3">
                <label for="age">Leeftijd</label>
                <input type="number" class="form-control" name="age" value="<?php echo $data['user']->age?>">
            </div>
            <div class="col-6 col-md-3">
                <label for="gender">Gender</label>
                <input type="text" class="form-control" name="gender" value="<?php echo $data['user']->gender?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-pencil-square-o edit-icon-profile"></i>
            Wijzig
        </button>
    </form>
    </div>
    </div>

<?php require APPROOT . "/views/inc/footer.php"?>