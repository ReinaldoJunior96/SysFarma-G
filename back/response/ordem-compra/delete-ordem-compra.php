<?php
require_once('../../controllers/CompraController.php');
$delete_ordem= new CompraController();
// var_dump($_GET['idsaida'],$_GET['prod'],$_GET['qtde']);
$delete_ordem->deleteOC($_GET['idordem']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>