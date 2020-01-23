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
$users = $data['users'];
$offers = $data['offers'];
$comms = $data['comms'];
?>
<?php if (!empty($_SESSION['flash'])) {
    $_SESSION['flash']->show();
    unset($_SESSION['flash']);
} ?>
<div class="row mb-3">
    <div class="col">
        <h1>Admin dashboard</h1>
    </div>
</div>
<div class="accordion" id="accordionExample">
    <div class="card">
        <div class="card-header btn btn-light" id="headingOne" type="button" data-toggle="collapse"
             data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <h2 class="mb-0">
                <h4 class="pull-left">Werkgevers</h4>
            </h2>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <a href="<?php echo URLROOT . "Admins/addComp" ?>">
                            <button type="button" class="btn btn-success">
                                <i class="fa fa-plus"></i> Nieuwe werkgever
                            </button>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-striped table-hover text-center border shadow-sm">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Gebruikersnaam</th>
                                <th scope="col">Email</th>
                                <th scope="col">Bedrijfsnaam</th>
                                <th scope="col">Stad</th>
                                <th scope="col">Wijzigen</th>
                                <th scope="col">Verwijderen</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($comps as $comp): ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo URLROOT . "Companys/profile/" . $comp->comp_username ?>">
                                            <?php echo $comp->comp_username; ?>
                                        </a>
                                    </td>
                                    </a>
                                    <td>
                                        <a href="<?php echo URLROOT . "Companys/profile/" . $comp->comp_username ?>">
                                            <?php echo $comp->comp_email; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo URLROOT . "Companys/profile/" . $comp->comp_username ?>">
                                            <?php echo $comp->comp_name; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo URLROOT . "Companys/profile/" . $comp->comp_username ?>">
                                            <?php echo $comp->comp_city; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo URLROOT . "Admins/editComp/" . $comp->comp_id ?>">
                                            <button type="button" class="btn btn-sm btn-warning"><i
                                                        class="fa fa-pencil-square-o"></i></button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo URLROOT . "Admins/delComp/" . $comp->comp_id ?>">
                                            <button type="button" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-times"></i></i></button>
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="card">
            <div class="card-header btn btn-light" id="headingTwo" type="button" data-toggle="collapse"
                 data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <h2 class="mb-0">
                    <h4 class="pull-left">Sollicitanten</h4>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <a href="<?php echo URLROOT . "/Users/register" ?>">
                                <button type="button" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Nieuwe sollicitant
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table class="table table-striped table-hover text-center border shadow-sm">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Gebruikersnaam</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Wijzigen</th>
                                    <th scope="col">Verwijderen</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo URLROOT . "Users/profile/" . $user->username ?>">
                                                <?php echo $user->username; ?>
                                            </a>
                                        </td>
                                        </a>
                                        <td>
                                            <a href="<?php echo URLROOT . "Users/profile/" . $user->username?>">
                                                <?php echo $user->email; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo URLROOT . "Admins/editUser/" . $user->id ?>">
                                                <button type="button" class="btn btn-sm btn-warning"><i
                                                            class="fa fa-pencil-square-o"></i></button>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo URLROOT . "Admins/delUser/" . $comp->comp_id ?>">
                                                <button type="button" class="btn btn-sm btn-danger"><i
                                                            class="fa fa-times"></i></i></button>
                                            </a>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header btn btn-light" id="headingThree" type="button" data-toggle="collapse"
                 data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                <h2 class="mb-0">
                    <h4 class="pull-left">Vacatures</h4>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <table class="table table-striped table-hover text-center border shadow-sm">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Titel</th>
                                    <th scope="col">Geplaatste datum</th>
                                    <th scope="col">Reacties</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($offers as $offer): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo  URLROOT . "Offers/show/" . $offer->offer_id;?>">
                                                <?php echo $offer->offer_title?>
                                            </a>
                                        </td>
                                        </a>
                                        <td>
                                            <a href="<?php echo  URLROOT . "Offers/show/" . $offer->offer_id;?>">
                                                <?php echo $offer->offer_date?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo URLROOT . "Offers/showResponses/ " . $offer->offer_id ?>">
                                                <?php echo $offer->resps ?>
                                            </a>
                                        </td>
                                    </tr>

                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="card">
        <div class="card-header btn btn-light" id="headingFour" type="button" data-toggle="collapse"
             data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
            <h2 class="mb-0">
                <h4 class="pull-left">Facturen</h4>
            </h2>
        </div>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-striped table-hover text-center border shadow-sm">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Bedrijf</th>
                                <th scope="col">Vacature</th>
                                <th scope="col">Commissie</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($comms as $comm): ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo  URLROOT . "Offers/show/" . $comm->offer_id;?>">
                                            <?php echo $comm->comp_username?>
                                        </a>
                                    </td>
                                    </a>
                                    <td>
                                        <a href="<?php echo  URLROOT . "Offers/show/" . $comm->offer_id;?>">
                                            <?php echo $comm->offer_title?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo URLROOT . "Offers/showResponses/ " . $comm->offer_id ?>">
                                            <?php echo $comm->total_comm ?>
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require APPROOT . "/views/inc/footer.php" ?>


