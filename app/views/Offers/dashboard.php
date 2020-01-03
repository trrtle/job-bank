<?php
/**
 * Company/dashboard.php
 *
 * @package    TurtleMVC-Core
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 * @uses bootstrap4
 */

require APPROOT . "/views/inc/header.php";
/** @var array $data */
$offers = $data['offers'];
?>
<?php if(!empty($_SESSION['flash'])) {$_SESSION['flash']->show(); unset($_SESSION['flash']);}?>
    <h1 class="mb-5">Welkom <?php echo ucwords($_SESSION['comp_username']) ?></h1>
<div class="row mb-3">
    <a href="<?php echo URLROOT . "Offers/add"; ?>">
        <button type="button" class="btn btn-success">
            <i class="fa fa-pencil"></i> Nieuwe vacature
        </button>
    </a>
</div>
    <h2>Geplaatste vacatures</h2>
    <table class="table table-striped table-hover text-center">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Titel</th>
            <th scope="col">Geplaatste datum</th>
            <th scope="col">Reacties</th>
            <th scope="col">wijzig</th>
            <th scope="col">Verwijderen</th>
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
                    <a href="#">
                       10
                    </a>
                </td>
                <td>
                    <a href="<?php echo URLROOT . "Offers/edit/" . $offer->offer_id?>">
                        <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o"></i></button>
                    </a>
                </td>
                <td>
                    <a href="<?php echo URLROOT . "Offers/delete/" . $offer->offer_id?>">
                        <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></i></button>
                    </a>
                </td>
            </tr>

        <?php endforeach;?>
        </tbody>
    </table>
<?php require APPROOT . "/views/inc/footer.php" ?>