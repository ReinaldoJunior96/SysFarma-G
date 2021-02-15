<?php
require_once('../../controllers/AvariaController.php');
$avariaClass = new AvariaController();
if ($avariaClass->novoProdudoAvariado($_POST) == 0):
    header("location: ../../../views/avaria/cadastro-avaria.php?status=success");
else:
    header("location: ../../../views/avaria/cadastro-avaria.php?status=fail");
endif;


?>