<?php
require_once('../../controllers/SetorController.php');

$s = new SetorController();
$s->storeSetor(@$_POST['novo_setor']);
echo "<script language=\"javascript\">window.history.back();</script>";
