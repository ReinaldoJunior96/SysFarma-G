<?php 
require_once('../../controllers/NotaFiscalController.php');

$delete_nf = new NotaFiscalController();
$delete_nf->delete_NF($_GET['idnf']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>