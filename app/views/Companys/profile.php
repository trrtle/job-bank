<?php
/**
 * users/profile.php
 *
 * @package    TurtleMVC-Core
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 * @uses bootstrap4
 */

require APPROOT . "/views/inc/header.php";
/** @var array $data */
$comp = $data['company'];
?>
    <?php if($_SESSION['comp_id'] == $comp->comp_id && $_SESSION['comp_username'] == $comp->comp_username): ?>
        <?php if(!empty($_SESSION['flash'])) {$_SESSION['flash']->show();}?>
        <div class="row">
            <div class="col offset-10">
                <a href="<?php echo URLROOT ?>/companys/edit">
                    <button type="button" class="btn btn-primary">
                        <i class="fa fa-pencil-square-o edit-icon-profile"></i> Wijzig
                    </button>
                </a>
            </div>
        </div>
    <?php endif ?>
<!--echo URLROOT . "public/img/" . $user->username . ".avatar"-->
</div>
<div class="card card-body bg-white mt-3">
<div class="row text-center ">
    <div class="col-6">
        <img src="<?php echo URLROOT  . $comp->comp_image?>" class="img-thumbnail avatar">
    </div>
    <div class="col-6">
        <div class="card">
            <ul class="list-group">
                <li class="list-group-item">
                        <h3><strong class="pull-left">Naam: </strong><span class="pull-right"><?php  echo ucfirst($comp->comp_name) ?></h3></span>
                </li>
                <li class="list-group-item">
                    <strong class="pull-left">
                        Plaats:
                    </strong>
                    <span class="pull-right">
                            <?php echo $comp->comp_city ?>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
<?php require APPROOT . "/views/inc/footer.php"?>

