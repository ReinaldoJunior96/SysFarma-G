<?php
include '../../controllers/CompraController.php';
date_default_timezone_set('America/Sao_Paulo');
$f = new CompraController();
$data = new DateTime();
$f->cadastroOrdemCompra($_POST['nome_f'], @$_POST['info_ne']);

echo "<script language=\"javascript\">window.history.back();</script>";