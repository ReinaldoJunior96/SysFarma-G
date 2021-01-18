<?php
require_once('../../controllers/NotaFController.php');
$dataVencimento = array(
    'notaid'=>$_POST['idnf'],
    'vencimento'=>$_POST['d_vencimento'],
);
$venciemento = new NotaFController();
$venciemento->venciementoParcelas($dataVencimento);
echo "<script language=\"javascript\">window.history.back();</script>";


?>