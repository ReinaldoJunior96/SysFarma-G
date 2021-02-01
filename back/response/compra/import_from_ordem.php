<?php
require_once('../../controllers/NotaFiscalController.php');
$importDados = new NotaFiscalController();
$importDados->importData($_GET['idnf']);
echo "<script language=\"javascript\">window.history.back();</script>";
?>