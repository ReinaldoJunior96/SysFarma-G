<?php
require_once('../../controllers/NotaFiscalController.php');
$importDados = new NotaFiscalController();
$importDados->lancarQtdeNFinEstoque($_GET['idnf']);
header("location: ../../../views/nota-fiscal/edit-nf-view.php?idnf=" . $_GET['idnf'] . "&status=success");
//echo "<script language=\"javascript\">window.history.back();</script>";
?>