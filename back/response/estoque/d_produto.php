<?php
require_once('../../controllers/EstoqueController.php');
$estoque = new EstoqueController();
$estoque->destroyProduto($_GET['idp']);
//header("Location: ../../../views/estoque/produtos-farmacia.php");
echo "<script language=\"javascript\">window.history.go(-2);</script>";
?>

