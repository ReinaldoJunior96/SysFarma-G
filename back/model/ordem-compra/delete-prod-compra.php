<?php
require_once('../../controllers/CompraController.php');
$deleteProd= new CompraController();
$deleteProd->deletePOC($_GET['deleteprod']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>