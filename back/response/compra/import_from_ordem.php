<?php
require_once('../../controllers/NotaFController.php');
$importDados = new NotaFController();
$importDados->importData($_GET['idnf']);
echo "<script language=\"javascript\">window.history.back();</script>";
?>