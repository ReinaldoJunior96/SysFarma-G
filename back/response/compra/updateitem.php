<?php
require_once('../../controllers/CompraController.php');
$alterarProd = new CompraController();
// var_dump($_GET['idsaida'],$_GET['prod'],$_GET['qtde']);
$alterarProd->alterarItemCompra($_POST['idcompra'], $_POST['idproditem'], $_POST['qtdecomprada'], $_POST['idordem'], $_POST['valoruni']);
echo "<script language=\"javascript\">window.history.back();</script>";


