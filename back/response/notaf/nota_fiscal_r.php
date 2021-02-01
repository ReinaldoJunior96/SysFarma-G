<?php
require_once('../../controllers/NotaFiscalController.php');
$notaData = new NotaFiscalController();
$nf = array(
    'numero' => $_POST['numero_nf'],
    'data_e' => $_POST['datae_nf'],
    'data_l' => $_POST['datal_nf'],
    'fornecedor' => $_POST['fornecedor_nf'],
    'valor' => $_POST['valor_nf'],
    'desconto' => $_POST['desconto'],
    'frete' => $_POST['frete'],
    'valor_total' => $_POST['valor_total'],
    'obs' => $_POST['obs_nf'],
    'nota_entrega' => $_POST['info_ne']
);


if ($_POST['tipo'] == 'edit') {
    $notaData->edit_NF($nf, $_POST['idnf']);
    echo "<script language=\"javascript\">window.history.back();</script>";
} elseif ($_POST['tipo'] == 'new') {
    $notaData->insert($nf);
    echo "<script language=\"javascript\">window.history.back();</script>";
}


?>