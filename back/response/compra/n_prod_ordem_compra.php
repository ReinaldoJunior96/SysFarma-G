<?php
include '../../controllers/CompraController.php';
$f = new CompraController();
$valoratt = str_replace(',','.',$_POST['valor_un_c']);
$f->addProdCompra($_POST['selectprodid'], $_POST['ordem'], $_POST['saidaqte_p'], floatval($valoratt));
echo "<script language=\"javascript\">window.history.back();</script>";

