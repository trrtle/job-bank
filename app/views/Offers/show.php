<?php
/**
 * Company/show.php
 *
 * @package    TurtleMVC-Core
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 * @uses bootstrap4
 */

require APPROOT . "/views/inc/header.php";
/** @var array $data */
?>
<div class="jumbotron mb-5 text-center">
    <h1 class="display-4"><?php echo $data['offer']->offer_title?></h1>
    <a href="<?php echo URLROOT . "companys/profile/" . $data['comp']->comp_username ;?>">
        <p class="lead"><?php echo $data['comp']->comp_name?></p>
    </a>

</div>
<div class="row text-center">
    <div class="col">
        <?php echo $data['offer']->offer_desc; ?>
        <hr>
        <div ><a class="btn btn-primary btn-lg" href="<?php echo URLROOT . "Responses/add/" . $data['offer']->offer_id?>" role="button">Solliciteer nu!</a></div>
    </div>
</div>


<?php require APPROOT . "/views/inc/footer.php" ?>
