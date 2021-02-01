<?php
require_once('../../controllers/configCRUD.php');

/* Adicionar */
if(@$_POST['setor'] == 1){
    $s = new ConfigCRUD();
    $s->insertSetor(@$_POST['novo_setor']);
    echo "<script language=\"javascript\">window.history.back();</script>";
}

/* Remover */
if(!empty($_GET['id_setor'])){
    $s = new ConfigCRUD();
    $s->delete_setor($_GET['id_setor']);
    echo "<script language=\"javascript\">window.history.back();</script>";
}
