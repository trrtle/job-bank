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

require APPROOT . "/views/inc/header.php";
/** @var array $data */
$comps = $data['comps'];
?>
<?php if(!empty($_SESSION['flash'])) {$_SESSION['flash']->show(); unset($_SESSION['flash']);}?>
<div class="row mb-3">
    <div class="col">
        <h1>Werkgever toevoegen</h1>
    </div>
</div>

<div class="row">
    <div class="col">
        <form class="form-group" action="<?php echo URLROOT ?>Admins/addComp" method="post">
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" name="username" value="<?php echo $data['username']; ?>" class="form-control
                    <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                </div>
                <div class="col-12 col-md-6">
                    <label for="email">Email adres</label>
                    <input type="email" name="email" value="<?php echo $data['email']; ?>" class="form-control
                    <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" >
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="secret">wachtwoord</label>
                    <input type="password" name="secret" class="form-control
                    <?php echo (!empty($data['secret_err'])) ? 'is-invalid' : ''; ?>" >
                    <span class="invalid-feedback"><?php echo $data['secret_err']; ?></span>
                </div>
                    <div class="col-12 col-md-6">
                        <label for="secret_confirm">Herhaal wachtwoord</label>
                        <input type="password" name="secret_confirm" class="form-control
                        <?php echo (!empty($data['secret_conf_err'])) ? 'is-invalid' : ''; ?>" >
                        <span class="invalid-feedback"><?php echo $data['secret_conf_err']; ?></span>
                    </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="name">Bedrijfsnaam</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $data['comp-name']; ?>">
                </div>
                <div class="col-12 col-md-6">
                    <label for="city">Stad</label>
                    <input type="text" class="form-control" name="city" value="<?php echo $data['city']; ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="fa fa-plus"></i></i>
                Toevoegen
            </button>
        </form>
    </div>
</div>


<?php require APPROOT . "/views/inc/footer.php"?>


