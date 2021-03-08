<?php
$produto = $_GET['produtoid'];
require_once('../../../controllers/conexao.php');
$conn = PDOconectar::conectar();
$queryBuscaEstoque = $conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE id_estoque = $produto");
$queryBuscaEstoque->execute();
echo json_encode($queryBuscaEstoque->fetchAll(PDO::FETCH_ASSOC));
//return $queryBuscaEstoque->fetchAll(PDO::FETCH_OBJ);