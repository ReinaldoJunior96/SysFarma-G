<?php

require_once('../../controllers/FornecedorController.php');

$deleteFornecedor = new FornecedorController();
$deleteFornecedor->destroyFornecedor($_GET['idfornecedor']);
echo "<script language=\"javascript\">window.history.back();</script>";


