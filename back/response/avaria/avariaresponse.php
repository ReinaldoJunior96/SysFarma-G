<?php
require_once('../../controllers/AvariaController.php');
$avariaClass = new AvariaController();
$avariaClass->novoProdudoAvariado($_POST);
echo "<script language=\"javascript\">window.history.back();</script>";

?>