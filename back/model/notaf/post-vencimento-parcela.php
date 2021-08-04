<?php
require_once('../../controllers/NotaFiscalController.php');
$dataVencimento = array(
    'notaid'=>$_POST['idnf'],
    'vencimento'=>$_POST['d_vencimento'],
);
$venciemento = new NotaFiscalController();
$venciemento->storeVencimentoNF($dataVencimento);
echo "<script language=\"javascript\">window.history.back();</script>";


?>