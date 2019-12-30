<?php
/**
 * Company/overview.php
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
    <h1 class="mb-5">Welkom <?php echo ucwords($_SESSION['comp_username']) ?></h1>
    <h2>Geplaatste vacatures</h2>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Titel</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Geplaatste datum</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($offers as $offer): ?>
        <tr>
            <td><?php echo $offer->offer_title?></td>
            <td><?php echo substr($offer->offer_desc, 0, 80)?>...</td>
            <td><?php echo $offer->offer_date?></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php require APPROOT . "/views/inc/footer.php" ?>