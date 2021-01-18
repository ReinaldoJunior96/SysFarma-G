<?php
require_once('../../controllers/EstoqueController.php');
$delete_saida = new EstoqueController();
// var_dump($_GET['idsaida'],$_GET['prod'],$_GET['qtde']);
$delete_saida->cancelarSaida($_GET['idsaida'],$_GET['prod'],$_GET['qtde'],$_GET['user']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>