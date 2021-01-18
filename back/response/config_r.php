<?php 
require_once('../controllers/configCRUD.php');

/* Adicionar */
if(@$_POST['setor'] == 1){
    $s = new ConfigCRUD();
    $s->insertSetor(@$_POST['novo_setor']);
    echo "<script language=\"javascript\">window.history.back();</script>";
}elseif(@$_POST['marca'] == 1){
    $s = new ConfigCRUD();
    $s->insertMarca(@$_POST['nova_marca']);
    echo "<script language=\"javascript\">window.history.back();</script>";
}elseif(@$_POST['uni_medida'] == 1){
    $u = new ConfigCRUD();
    $u->insertUNM(@$_POST['nova_uni_medida']);
    echo "<script language=\"javascript\">window.history.back();</script>";
}elseif(@$_POST['categoria'] == 1){
    $u = new ConfigCRUD();
    $u->insertCategoria(@$_POST['nova_categoria']);
    echo "<script language=\"javascript\">window.history.back();</script>";
}

/* Remover */
if(!empty($_GET['id_setor'])){
    $s = new ConfigCRUD();
    $s->delete_setor($_GET['id_setor']);
    echo "<script language=\"javascript\">window.history.back();</script>";
}elseif(!empty($_GET['idmarca'])){
    $s = new ConfigCRUD();
    $s->delete_marca($_GET['idmarca']);
    echo "<script language=\"javascript\">window.history.back();</script>";
}elseif(!empty($_GET['idunim'])){
    $u = new ConfigCRUD();
    $u->delete_UNM($_GET['idunim']);
    echo "<script language=\"javascript\">window.history.back();</script>";
}elseif(!empty($_GET['idcategoria'])){
    $c = new ConfigCRUD();
    $c->delete_categoria($_GET['idcategoria']);
    echo "<script language=\"javascript\">window.history.back();</script>";
}
