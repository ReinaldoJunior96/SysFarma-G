<?php
require_once('../../controllers/FornecedorController.php');

$deleteFornecedor = new FornecedorController();
if ($deleteFornecedor->deleteFornecedor($_GET['idfornecedor']) == 0):
    header("location: ../../../views/fornecedor/cadastro-fornecedor.php?status=success");
else:
    header("location: ../../../views/fornecedor/cadastro-fornecedor.php?status=fail");
endif;




//echo "<script language=\"javascript\">window.history.back();</script>";


