<?php
require_once('../../controllers/EstoqueController.php');
$estoque = new EstoqueController();
$estoque->destroyProduto($_GET['idp']);
//header("Location: ../../../views/estoque/nv_estoque.php");
echo "<script language=\"javascript\">window.history.go(-2);</script>";
?>

