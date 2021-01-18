<?php
require_once('../../controllers/CompraController.php');
$deleteProd= new CompraController();
$deleteProd->deleteProdOrdem($_GET['idprod']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>