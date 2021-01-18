<?php
require_once('../../controllers/NotaFController.php');

$deleteL = new NotaFController();
$deleteL->deleteLote($_GET['idl']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>