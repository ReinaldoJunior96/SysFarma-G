<?php
require_once('../../controllers/EstoqueController.php');
$estoque = new EstoqueController();
$estoque->fornecedorProduto($_POST['produto'],$_POST['fornecedor']);
echo "<script language=\"javascript\">window.history.back();</script>";
?>