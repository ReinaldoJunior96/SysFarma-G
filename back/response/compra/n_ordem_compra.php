<?php
include '../../controllers/CompraController.php';
date_default_timezone_set('America/Sao_Paulo');
$f = new CompraController();
$data = new DateTime();
$f->cadOrdemCompra($_POST['nome_f'],@$_POST['info_ne'],(empty($_POST['data_c']))
    ? $data->format('Y-m-d H:i:s')
    : date("Y-m-d H:i:s", strtotime($_POST['data_c'])));

echo "<script language=\"javascript\">window.history.back();</script>";