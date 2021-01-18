<?php
require_once('../../controllers/NotaFController.php');

$deleteVencimento = new NotaFController();
$deleteVencimento->deleteVencimento($_GET['idv']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>