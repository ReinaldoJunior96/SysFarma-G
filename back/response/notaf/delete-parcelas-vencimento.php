<?php
require_once('../../controllers/NotaFiscalController.php');

$deleteVencimento = new NotaFiscalController();
$deleteVencimento->deleteVencimento($_GET['idv']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>