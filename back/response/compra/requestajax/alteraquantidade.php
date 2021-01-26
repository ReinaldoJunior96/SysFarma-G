<?php
$produto = $_GET['produtoid'];
require_once('../../controllers/conexao.php');

$conn = PDOconectar::conectar();

$queryUpdate = /** @lang text */
    "UPDATE tbl_items_compra SET 
            item_compra=:item_compra,
			ordem_compra_id=:ordem_compra_id,
			qtde_compra=:qtde_compra,
			valor_un_c=:valor_un_c
			WHERE id_item_compra='$produto'";
$newValue = $conn->prepare($queryUpdate);
$newValue->bindValue(':principio_ativo', $produto['p_ativo']);
$newValue->bindValue(':principio_ativo', $produto['p_ativo']);
$newValue->bindValue(':principio_ativo', $produto['p_ativo']);
$newValue->bindValue(':principio_ativo', $produto['p_ativo']);
$newValue->execute();


$selectQuery = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_ordem_compra
		INNER JOIN tbl_items_compra 
		ON tbl_ordem_compra.id_ordem = tbl_items_compra.ordem_compra_id
		INNER JOIN tbl_estoque
		ON tbl_items_compra.item_compra = tbl_estoque.id_estoque
		WHERE tbl_ordem_compra.id_ordem='$idOrdem'");
$selectQuery->execute();
echo json_encode($selectQuery->fetchAll(PDO::FETCH_ASSOC));