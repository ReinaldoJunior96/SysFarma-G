<?php
require_once('../../controllers/SetorController.php');
$s = new SetorController();
$s->deleteSetor($_GET['setor']);
if ($s->deleteSetor($_GET['setor']) == 0):
    header("location: ../../../views/setores/cadastro-setor.php?status=success");
else:
    header("location: ../../../views/setores/cadastro-setor.php?status=fail");
endif;
