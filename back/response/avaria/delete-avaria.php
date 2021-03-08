<?php
require_once('../../controllers/AvariaController.php');
$avariaClass = new AvariaController();
$avariaClass->deletePA($_GET['avaria'], $_GET['usuario']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>