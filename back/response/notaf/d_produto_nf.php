<?php 
require_once('../../controllers/NotaFController.php');

$delete_prod_nf = new NotaFController();
$delete_prod_nf->deleteProdNF($_GET['id_prod_nf'],$_GET['item_estoque'],$_GET['qtde_nf']);
echo "<script language=\"javascript\">window.history.back();</script>";


?>