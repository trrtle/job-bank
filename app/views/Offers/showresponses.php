<?php
require APPROOT . "/views/inc/header.php";
/** @var array $data */
?>
<div class="row mb-3">
    <div class="col">
        <h1>Reacties op de vacature: <?php echo $data['offer']->offer_title?></h1>
    </div>
</div>

<div class="row mb-5">
    <div class="col">
        <table class="table table-striped table-hover text-center border shadow-sm">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Sollicitant</th>
                <th scope="col">Datum</th>
                <th scope="col">Comissie</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data['resps'] as $resps=>$resp): ?>
                <tr>
                    <td>
                        <a href="<?php echo  URLROOT . "Responses/show/" . $resp->resp_id;?>">
                            <?php echo (!empty($resp->firstname) ? $resp->firstname . ' ' . $resp->lastname : $resp->username )?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo  URLROOT . "Responses/show/" . $resp->resp_id;?>">
                            <?php echo $resp->resp_date?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo  URLROOT . "Responses/show/" . $resp->resp_id;?>">
                             <?php echo ( $data['commCount'] == 0 ? "Betaald" : "€ " . COMMISSION) ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach;?>
            <tr>
                <td></td>
                <td><h4>Totaal: </h4></td>
                <td><h4>€ <?php echo $data['commCount'] * COMMISSION; ?></h4></td>
            </tr>
            </tbody>
        </table>
        <hr class="mt-5">
    </div>
</div>

<?php require APPROOT . "/views/inc/footer.php" ?>