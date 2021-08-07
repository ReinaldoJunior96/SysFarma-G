<?php
require_once('../../controllers/CompraController.php');
$alterarProd = new CompraController();
// var_dump($_GET['idsaida'],$_GET['prod'],$_GET['qtde']);
$alterarProd->updateItemOC($_POST['idcompra'], $_POST['qtdecomprada']);
echo "<script language=\"javascript\">window.history.back();</script>";


