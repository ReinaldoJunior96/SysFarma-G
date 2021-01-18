<?php 
require_once('../../controllers/bhCRUD.php');
$p = new BhCRUD();
// $produtos = $p->relatorio1($_POST['id_produto'],$_POST['setor'],$_POST['dataI'],$_POST['dataF']);
$produtos = $p->relatorio1($_POST['setor']);

var_dump($produtos);
