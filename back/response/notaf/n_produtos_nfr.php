<?php 
require_once('../../controllers/NotaFController.php');
$produto_nf = array(
	'lote' => $_POST['lote_pnf'],
	'validade' => $_POST['validade_pnf'],
);

$edit = new NotaFController();
$edit->editProfNF($produto_nf,$_POST['id_item']);
//echo "<script language=\"javascript\">window.history.back();</script>";


?>