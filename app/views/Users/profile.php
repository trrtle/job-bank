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

<div class="row text-center mb-5">
    <div class="col col-12">
       <h1>Profiel</h1>
    </div>

</div>
<div class="row text-center">
    <div class="col-6">
        <img src="<?php echo URLROOT ?>public/img/stewie.jpg" class="img-thumbnail avatar">
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

<?php require APPROOT . "/views/inc/footer.php"?>
