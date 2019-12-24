<?php
/**
 * users/settings.php
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

<?php if(!empty($_SESSION['flash'])) {$_SESSION['flash']->show();}?>
<div class="row">
    <h1>Account instellingen</h1>
</div>


<div class="accordion" id="accordionExample">
    <div class="card">
        <div class="card-header" id="headingOne">
            <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <h5>Wijzig je e-mail adres</h5>
            </button>
        </div>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <form class="ml-3 mr-3" action="<?php echo URLROOT?>users/settings" method="POST">
                    <div class="row mb-3">
                        <input type="email" class="form-control" name="email" value="<?php echo $data['email']?>">
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-primary " value="email">
                            <i class="fa fa-pencil-square-o edit-icon-profile"></i>
                            Wijzig
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <h5>Wijzig je wachtwoord</h5>
            </button>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <form class="ml-3 mr-3" action="<?php echo URLROOT?>users/settings" method="POST">
                    <div class="row mb-3">
                        <input type="password" class="form-control" name="secret" placeholder="wachtwoord">
                    </div>
                    <div class="row mb-3">
                        <input type="password" class="form-control" name="secret_confirm" placeholder="Herhaal wachtwoord">
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-pencil-square-o edit-icon-profile"></i>
                            Wijzig
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . "/views/inc/footer.php"?>
