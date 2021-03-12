<?php 
require_once('../../controllers/NotaFiscalController.php');

$delete_nf = new NotaFiscalController();
$delete_nf->deleteNF($_GET['idnf']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>