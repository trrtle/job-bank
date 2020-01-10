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
<div class="row mb-3">
    <div class="col">
        <h1>Welkom <?php echo ucwords($_SESSION['comp_username']) ?></h1>
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <a href="<?php echo URLROOT . "Offers/add"; ?>">
            <button type="button" class="btn btn-success shadow-sm">
                <i class="fa fa-pencil"></i> Nieuwe vacature
            </button>
        </a>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <h2>Geplaatste vacatures</h2>
    </div>
</div>
<div class="row mb-5">
    <div class="col">
        <table class="table table-striped table-hover text-center border shadow-sm">
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
                        <a href="<?php echo URLROOT . "/Offers/showResponses/ " . $offer->offer_id ?>">
                            <?php echo $offer->resps ?>
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
        <hr class="mt-5">
    </div>
</div>


<?php require APPROOT . "/views/inc/footer.php" ?>