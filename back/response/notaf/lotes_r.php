<?php
require_once('../../controllers/NotaFiscalController.php');
$loteValidade = array(
    'notaFiscal' => $_POST['idnf'],
    'produto' => $_POST['prod_nf'],
    'lote' => $_POST['lote_prod_nf'],
    'validade' => $_POST['validade_prof_nf'],
);

$lote = new NotaFiscalController();
$lote->cadLote($loteValidade);
echo "<script language=\"javascript\">window.history.back();</script>";


?>