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
$user = $data['user'];
?>
    <?php if($_SESSION['id'] == $user->id && $_SESSION['username'] == $user->username): ?>
        <?php if(!empty($_SESSION['flash'])) {$_SESSION['flash']->show();}?>
        <div class="row">
            <div class="col offset-10">
                <a href="<?php echo URLROOT ?>/Users/edit">
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
        <img src="<?php echo URLROOT  . $user->image?>" class="img-thumbnail avatar">
    </div>
    <div class="col-6">
        <div class="card">
            <ul class="list-group">
                <li class="list-group-item">
                    <?php if (isset($user->firstname) || isset($user->lastname)):?>
                        <h3><strong class="pull-left">
                                Naam:
                            </strong>
                            <span class="pull-right">
                                <?php  echo ucfirst($user->firstname) . " " . ucfirst($user->lastname) ?>
                            </span>
                        </h3>
                    <?php else:?>
                        <h3><strong class="pull-left">Naam: </strong><span class="pull-right"><?php  echo ucfirst($user->username) ?></h3></span>
                    <?php endif; ?>
                </li>
                <li class="list-group-item">
                    <strong class="pull-left">
                        Leeftijd:
                    </strong>
                    <span class="pull-right">
                        <?php echo $user->age ?>
                    </span>
                </li>
                <li class="list-group-item">
                    <strong class="pull-left">
                        Woonplaats:
                    </strong>
                    <span class="pull-right">
                            <?php echo $user->city ?>
                    </span>
                </li>
                <li class="list-group-item">
                    <strong class="pull-left">
                        Gender:
                    </strong>
                    <span class="pull-right">
                        <?php echo $user->gender ?>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>

<?php require APPROOT . "/views/inc/footer.php"?>
