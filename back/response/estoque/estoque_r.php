<?php
require_once('../../controllers/EstoqueController.php');
$estoque = new EstoqueController();
$valorUNAtt = str_replace(',', '.', @$_POST['valor_un']);
$produto = array(
    'produto' => @$_POST['produto_e'],
    'p_ativo' => @$_POST['p_ativo'],
    'quantidade' => @$_POST['quantidade_e'],
    'valor' => floatval(@$valorUNAtt),
    'estoque_minimo_e' => @$_POST['estoque_minimo_e'],
    'principio_ativo' => @$_POST['p_ativo'],
    'concentracao' => @$_POST['concentracao'],
    'apresentacao' => @$_POST['apresentacao'],
    'forma_farmaceutica' => @$_POST['forma_farmaceutica'],
    'tipo' => (@$_POST['tipo'] == NULL) ? '0' : @$_POST['tipo'],
    'usuario' => $_POST['usuario']
);

if (@$_POST['new'] == 1) {
    var_dump($produto);
    $estoque->newProduto($produto);
    /*echo "<script language=\"javascript\">window.history.back();</script>";*/
} elseif (@$_POST['edit'] == 1) {
    $estoque->editProduto($produto, $_POST['id']);
    /*echo "<script language=\"javascript\">window.history.back();</script>";*/

}