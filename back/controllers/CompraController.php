<?php
require_once 'conexao.php';
require_once 'EstoqueController.php';
date_default_timezone_set('America/Sao_Paulo');

class CompraController
{
    public $conn = null;
    public $estoqueClass = null;
    public $data = null;

    public function __construct()
    {
        $this->conn = PDOconectar::conectar();
        $this->estoqueClass = new EstoqueController();
        $this->data = new DateTime('NOW');
    }
    public function storeOC($forcenedor, $infoNE)
    {
        try {
            $this->conn->beginTransaction();
            $queryCadastroNF = /** @lang text */
                "INSERT INTO tbl_nf(numero_nf,fornecedor,nota_entrega) VALUES (:numero_nf,:fornecedor,:nota_entrega)";
            $executeCadastroNF = $this->conn->prepare($queryCadastroNF);
            $executeCadastroNF->bindValue(':numero_nf', 'temp' . rand(0, 99999));
            $executeCadastroNF->bindValue(':fornecedor', $forcenedor);
            $executeCadastroNF->bindValue(':nota_entrega', $infoNE);
            $executeCadastroNF->execute();
            $lastID = $this->conn->lastInsertId();

            $queryCadastroOrdem = /** @lang text */
                "INSERT INTO tbl_ordem_compra(nome_f,data_c,id_fk_nf) VALUES (:nome_f,:data_c,:id_fk_nf)";
            $cadastroOrdemExecute = $this->conn->prepare($queryCadastroOrdem);
            $cadastroOrdemExecute->bindValue(':nome_f', $forcenedor);
            $cadastroOrdemExecute->bindValue(':data_c', $this->data->format('Y-m-d H:i:s'));
            $cadastroOrdemExecute->bindValue(':id_fk_nf', $lastID);
            $cadastroOrdemExecute->execute();
            $this->conn->commit();

            //self::storeNFTemp($forcenedor, $this->data->format('Y-m-d H:i:s'), $lastID);
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }
    public function deleteOC($id)
    {
        try {
            $this->conn->beginTransaction();
            $buscarOC = self::listUniqueOC($id);
            $notaFiscalID = $buscarOC[0]->id_fk_nf;
            $notaFiscalQuery = $this->conn->prepare(/** @lang text */ "DELETE FROM  tbl_nf WHERE id_nf='$notaFiscalID' AND status_nf='0'");
            $notaFiscalQuery->execute();
            $ordemCompraQuery = $this->conn->prepare(/** @lang text */ "DELETE FROM  tbl_ordem_compra WHERE id_ordem='$id'");
            $ordemCompraQuery->execute();
            $prodOrdemQuery = $this->conn->prepare(/** @lang text */ "DELETE FROM  tbl_items_compra WHERE ordem_compra_id='$id'");
            $prodOrdemQuery->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }
    public function adicionarPOC($produto, $ordemCompra, $qtdeCompra, $valorUn)
    {
        try {
            $this->conn->beginTransaction();
            $adicionarProdOCQuery = /** @lang text */
                "INSERT INTO tbl_items_compra(item_compra,ordem_compra_id,qtde_compra,valor_un_c) VALUES (:item_compra,:ordem_compra_id,:qtde_compra,:valor_un_c)";
            $executeAddProdOCQuery = $this->conn->prepare($adicionarProdOCQuery);
            $executeAddProdOCQuery->bindValue(':item_compra', $produto);
            $executeAddProdOCQuery->bindValue(':ordem_compra_id', $ordemCompra);
            $executeAddProdOCQuery->bindValue(':qtde_compra', $qtdeCompra);
            $executeAddProdOCQuery->bindValue(':valor_un_c', $valorUn);
            $executeAddProdOCQuery->execute();

            $updateValueEstoqueQuery = /** @lang text */
                "UPDATE tbl_estoque SET  valor_un_e=:valor_un_e WHERE id_estoque='$produto'";
            $executeUpdateValueEstoqueQuery = $this->conn->prepare($updateValueEstoqueQuery);
            $executeUpdateValueEstoqueQuery->bindValue(':valor_un_e', $valorUn);
            $executeUpdateValueEstoqueQuery->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }
    public function deletePOC($id)
    {
        try {
            $this->conn->beginTransaction();
            $deleteProdOCQuery = $this->conn->prepare(/** @lang text */
                "DELETE FROM tbl_items_compra WHERE id_item_compra='$id'");
            $deleteProdOCQuery->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }
    public function listOC(): array
    {
        $listOCAll = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_ordem_compra");
        $listOCAll->execute();
        return $listOCAll->fetchAll(PDO::FETCH_OBJ);
    }
    public function listUniqueOC($id): array
    {
        $listUniqueOCQuery = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_ordem_compra WHERE id_ordem='$id'");
        $listUniqueOCQuery->execute();
        return $listUniqueOCQuery->fetchAll(PDO::FETCH_OBJ);
    }
    public function listOCwithEstoque($idOrdem): array
    {
        $selectQuery = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_ordem_compra
		INNER JOIN tbl_items_compra
		ON tbl_ordem_compra.id_ordem = tbl_items_compra.ordem_compra_id
		INNER JOIN tbl_estoque
		ON tbl_items_compra.item_compra = tbl_estoque.id_estoque
		WHERE tbl_ordem_compra.id_ordem='$idOrdem'");
        $selectQuery->execute();
        return $selectQuery->fetchAll(PDO::FETCH_OBJ);
    }
    public function updateItemOC($iditemcompra, $qtde)
    {
        try {
            $this->conn->beginTransaction();
            $queryUpdate = /** @lang text */
                "UPDATE tbl_items_compra SET qtde_compra=:qtde_compra WHERE id_item_compra='$iditemcompra'";
            $executeUpdateQtde = $this->conn->prepare($queryUpdate);
            $executeUpdateQtde->bindValue(':qtde_compra', $qtde);
            $executeUpdateQtde->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }

    }
}
