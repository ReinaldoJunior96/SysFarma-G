<?php 
require_once('../../controllers/NotaFController.php');

$delete_nf = new NotaFController();
$delete_nf->delete_NF($_GET['idnf']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>