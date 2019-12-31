<?php
/**
 * users/index.php
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
<h1>Welkom <?php echo ucwords($_SESSION['username']) ?></h1>
<?php require APPROOT . "/views/inc/footer.php"?>