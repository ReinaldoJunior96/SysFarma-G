<?php
require_once('../../controllers/NotaFiscalController.php');

$deleteL = new NotaFiscalController();
$deleteL->deleteLote($_GET['idl']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>