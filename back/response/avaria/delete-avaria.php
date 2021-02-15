<?php
require_once('../../controllers/AvariaController.php');
$avariaClass = new AvariaController();
var_dump($_GET['avaria']);
var_dump($_GET['user']);
$avariaClass->deleteProdutoAvaria($_GET['avaria'], $_GET['user']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>