<?php
require_once('../../controllers/FornecedorController.php');
$f = new FornecedorController();
$fornecedor = array(
    'nome' => @$_POST['fornecedor'],
    'contato' => @$_POST['telefone_fornecedor'],
    'email' => @$_POST['email_fornecedor'],
    'cnpj' => @$_POST['cnpj_fornecedor'],
    'endereco' => @$_POST['endereco_fornecedor'],
);
if (@$_POST['new'] == 1) {
    $f->novoFornecedor($fornecedor);
} elseif (@$_POST['edit'] == 1) {
    $f->editFornecedor($fornecedor, $_POST['idfornecedor']);
}
?>
