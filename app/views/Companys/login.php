<?php
/**
 * views/Companys/login.php - Page where the user logs in.
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

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Login voor bedrijven</h2>
            <p>Vul hier uw login gegevens in</p>
            <form action="<?php echo URLROOT?>Companys/login" method="post">
                <div class="form-group">
                    <label for="username">Gebruikersnaam<sup>*</sup></label>
                    <input type="text" name="username" class="form-control form-control-lg
                    <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
                    <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="secret">Wachtwoord<sup>*</sup></label>
                    <input type="password" name="secret" class="form-control form-control-lg
                    <?php echo (!empty($data['secret_err'])) ? 'is-invalid' : ''; ?>" value="">
                    <span class="invalid-feedback"><?php echo $data['secret_err']; ?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-success btn-block">Login</button>
                    </div>
                    <div class="col">
                        <a href="#"><button type="button" class="btn btn-light">Als bedrijf kun je hier een account aanvragen</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . "/views/inc/footer.php"?>
