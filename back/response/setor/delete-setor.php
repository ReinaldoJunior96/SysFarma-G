<?php
require_once('../../controllers/SetorController.php');
$s = new SetorController();
$s->deleteSetor($_GET['setor']);
echo "<script language=\"javascript\">window.history.back();</script>";
