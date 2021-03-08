<?php
require_once('../../controllers/NotaFiscalController.php');

$deleteL = new NotaFiscalController();
$deleteL->deleteLoteProdNF($_GET['idl']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>