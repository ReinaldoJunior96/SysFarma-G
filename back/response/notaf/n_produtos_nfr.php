<?php 
require_once('../../controllers/NotaFiscalController.php');
$produto_nf = array(
	'lote' => $_POST['lote_pnf'],
	'validade' => $_POST['validade_pnf'],
);

$edit = new NotaFiscalController();
$edit->updateProdNF($produto_nf,$_POST['id_item']);
//echo "<script language=\"javascript\">window.history.back();</script>";


?>