<?php
require_once('../../controllers/NotaFiscalController.php');
$importDados = new NotaFiscalController();
$result = ($importDados->lancarQtdeNFinEstoque($_GET['idnf']) == true)? "success" : "fail" ;

header("location: ../../../views/nota-fiscal/edit-nf-view.php?idnf=" . $_GET['idnf'] . "&status=$result");
//echo "<script language=\"javascript\">window.history.back();</script>";
?>