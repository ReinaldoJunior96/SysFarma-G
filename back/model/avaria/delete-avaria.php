<?php
require_once('../../controllers/AvariaController.php');
$avariaClass = new AvariaController();
$return = ($avariaClass->deletePA($_GET['avaria'], $_GET['usuario']) == 0) ? 'success' : 'fail';
header("location: ../../../views/avaria/cadastro-avaria.php?status=" . $return);


?>