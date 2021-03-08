<?php
include '../../controllers/CompraController.php';
$f = new CompraController();
$valoratt = str_replace(',', '.', $_POST['valor_un_c']);
$f->adicionarPOC($_POST['selectprodid'], $_POST['ordem'], $_POST['saidaqte_p'], floatval($valoratt));

