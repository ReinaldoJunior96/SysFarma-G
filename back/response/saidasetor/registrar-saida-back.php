<?php
require_once('../../controllers/EstoqueController.php');
date_default_timezone_set('America/Sao_Paulo');
$estoqueClass = null;
$data = null;
$data = new DateTime('NOW');


$produtoFiltrado = array(
    'produto' => $_POST['produtoid'],
    'quantidade' => $_POST['quantidade_solicitada'],
    'setor' => $_POST['setor_s'],
    'data' => (empty($_POST['data_s'])) ? date_format($data, 'Y-m-d H:i:s') : date('Y-m-d', strtotime($_POST['data_s'])) . " " . $data->format('H:i:s'),
    'user' => $_POST['user'],
);


$estoqueClass = new EstoqueController();
$estoqueClass->inseirSaida($produtoFiltrado);