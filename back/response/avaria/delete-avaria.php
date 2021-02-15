<?php
require_once('../../controllers/AvariaController.php');
$avariaClass = new AvariaController();
$avariaClass->destroyAvaria($_GET['avaria'], $_GET['user']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>