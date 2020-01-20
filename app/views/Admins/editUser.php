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
$user = $data['user'];
?>
<div class="row mb-4">
    <div class="col">
        <h1>Wijzig de gegevens van: <?php echo $user->username ?></h1>
    </div>

</div>
<div class="row mb-3">
    <div class="col">
        <a href="<?php echo URLROOT . "Admins/dashboard/"; ?>">
            <button type="button" class="btn btn-danger"><i class="fa fa-arrow-left">
                </i> Terug
            </button>
        </a>
    </div>
</div>
<div class="row">
    <div class="col">
        <form class="form-group" action="<?php echo URLROOT . "Admins/editUser/" . $user->id ?>" method="post">
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" name="username" value="<?php echo $user->username; ?>" class="form-control
                    <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                </div>
                <div class="col-12 col-md-6">
                    <label for="email">Email adres</label>
                    <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control
                    <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" >
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
            </div>
            <button type="submit" class="btn btn-warning">
                <i class="fa fa-pencil-square-o"></i></i>
                Wijzigen
            </button>
        </form>
    </div>
</div>

<?php require APPROOT . "/views/inc/footer.php" ?>

