<?php
require_once('../../controllers/EstoqueController.php');
require_once('../../controllers/UsuarioController.php');
$devolucao = new EstoqueController();
$verificacao = new UsuarioController();
if (md5($_POST['autorizacao']) == 'c4de8ced6214345614d33fb0b16a8acd') {
    $devolucao->registrarDevolucao($_POST);
} else {
    header("location: ../../../views/saida/registrar-devolucao.php?status=0&idsaida=" . $_POST['idsaida']);
}


