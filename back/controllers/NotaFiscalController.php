<?php
require_once('conexao.php');
require_once('EstoqueController.php');

class NotaFiscalController
{
    public $conn = null;

    function __construct()
    {
        $this->conn = PDOconectar::conectar();
    }

    public function storeNF($nf)
    {
        try {
            $this->conn->beginTransaction();
            $query_Sql = /** @lang text */
                "INSERT INTO tbl_nf(numero_nf,data_emissao,data_lancamento,fornecedor,valor_nf,obs_nf)
			VALUES (:numero_nf,:data_emissao,:data_lancamento,:fornecedor,:valor_nf,:obs_nf)";
            $sql = $this->conn->prepare($query_Sql);
            $sql->bindValue(':numero_nf', $nf['numero']);
            $sql->bindValue(':data_emissao', $nf['data_e']);
            $sql->bindValue(':data_lancamento', $nf['data_l']);
            $sql->bindValue(':fornecedor', $nf['fornecedor']);
            $sql->bindValue(':valor_nf', $nf['valor']);
            $sql->bindValue(':obs_nf', $nf['obs']);
            $sql->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }
    public function deleteNF($id)
    {
        try {
            $itensNF = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_itens_nf WHERE id_nf='$id'");
            $itensNF->execute();
            $itens = $itensNF->fetchAll(PDO::FETCH_OBJ);
            /* Laço para diminuir a quantidade em estoque*/
            foreach ($itens as $v) {
                self::deleteProdNF($v->id_itens, $v->item_nf, $v->qtde_nf);
            }
            $deleteOrdem = $this->conn->prepare(/** @lang text */ "DELETE FROM  tbl_ordem_compra WHERE id_fk_nf='$id'");
            $deleteOrdem->execute();
            $delete_prod = $this->conn->prepare(/** @lang text */ "DELETE FROM  tbl_itens_nf WHERE id_nf='$id'");
            $delete_prod->execute();
            $delete_nf = $this->conn->prepare(/** @lang text */ "DELETE FROM  tbl_nf WHERE id_nf='$id'");
            $delete_nf->execute();
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }
    public function listUniqueNF($id): array
    {
        $notas = null;
        try {
            $find_nf = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_nf WHERE id_nf='$id'");
            $find_nf->execute();
            $notas = $find_nf->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
        return $notas;
    }
    public function updateNF($nf, $id)
    {
        try {
            $this->conn->beginTransaction();
            $query = /** @lang text */
                "UPDATE tbl_nf SET 
			numero_nf=:numero_nf,
			data_emissao=:data_emissao,
			data_lancamento=:data_lancamento,
			fornecedor=:fornecedor,
			valor_nf=:valor_nf,
			desconto=:desconto,
			frete=:frete,
			valor_total=:valor_total,
			obs_nf=:obs_nf,
			nota_entrega=:nota_entrega
			WHERE id_nf='$id'";
            $editar_nf = $this->conn->prepare($query);
            $editar_nf->bindValue(':numero_nf', $nf['numero']);
            $editar_nf->bindValue(':data_emissao', $nf['data_e']);
            $editar_nf->bindValue(':data_lancamento', $nf['data_l']);
            $editar_nf->bindValue(':fornecedor', $nf['fornecedor']);
            $editar_nf->bindValue(':valor_nf', $nf['valor']);
            $editar_nf->bindValue(':desconto', $nf['desconto']);
            $editar_nf->bindValue(':frete', $nf['frete']);
            $editar_nf->bindValue(':valor_total', $nf['valor_total']);
            $editar_nf->bindValue(':obs_nf', $nf['obs']);
            $editar_nf->bindValue(':nota_entrega', $nf['nota_entrega']);
            $editar_nf->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }
    public function verificarStatusNF($idnf): int
    {
        $verificar = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_items_compra
        INNER JOIN tbl_ordem_compra
        ON tbl_items_compra.ordem_compra_id = tbl_ordem_compra.id_ordem
        INNER JOIN tbl_nf
        on tbl_ordem_compra.id_fk_nf = tbl_nf.id_nf
        WHERE tbl_ordem_compra.id_fk_nf = '$idnf' AND tbl_nf.status_nf = 0");
        $verificar->execute();
        return $verificar->rowCount();
    }
    public function lancarQtdeNFinEstoque($idnf)
    {
        try {
            $this->conn->beginTransaction();
            /* Busca a ordem */
            $importOrdem = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_items_compra
            INNER JOIN tbl_ordem_compra
            ON tbl_items_compra.ordem_compra_id = tbl_ordem_compra.id_ordem
            INNER JOIN tbl_nf
            on tbl_ordem_compra.id_fk_nf = tbl_nf.id_nf
            WHERE tbl_ordem_compra.id_fk_nf = '$idnf' AND tbl_nf.status_nf = 0");
            $importOrdem->execute();

            /* pega os produtos desta ordem encontrada */
            $dados = $importOrdem->fetchAll(PDO::FETCH_OBJ);
            /* percorre pelos produtos inserindo na tabela dos itens da nf */
            foreach ($dados as $v) {
                $produto_nf = array(
                    'produto' => $v->item_compra,
                    'quantidade' => $v->qtde_compra,
                    'lote' => "",
                    'validade' => "",
                    'nota-fiscal' => $idnf
                );
                $query_Sql = /** @lang text */
                    "INSERT INTO tbl_itens_nf(item_nf,qtde_nf,lote_e,validade_prod_nf,id_nf) 
                VALUES (:item_nf,:qtde_nf,:lote_e,:valiadde_prod_nf,:id_nf)";
                $sql = $this->conn->prepare($query_Sql);
                $sql->bindValue(':item_nf', $produto_nf['produto']);
                $sql->bindValue(':qtde_nf', $produto_nf['quantidade']);
                $sql->bindValue(':lote_e', $produto_nf['lote']);
                $sql->bindValue(':valiadde_prod_nf', $produto_nf['validade']);
                $sql->bindValue(':id_nf', $produto_nf['nota-fiscal']);
                $sql->execute();

                $produto = $produto_nf['produto'];
                $qtde_antiga_sql = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE id_estoque='$produto'");
                $qtde_antiga_sql->execute();
                $query_result = $qtde_antiga_sql->fetchAll(PDO::FETCH_OBJ);

                $qtde_nova = 0;
                $qtde_antiga = 0;

                foreach ($query_result as $v) {
                    $qtde_antiga = $v->quantidade_e;
                    $qtde_nova = $qtde_antiga + $produto_nf['quantidade'];
                }

                $alterar_estoque = /** @lang text */
                    "UPDATE tbl_estoque SET quantidade_e=:quantidade WHERE id_estoque='$produto'";
                $fazer_alteracao = $this->conn->prepare($alterar_estoque);
                $fazer_alteracao->bindValue(':quantidade', $qtde_nova);
                $fazer_alteracao->execute();

                $transacao = array(
                    'produto' => $produto_nf['produto'],
                    'data' => date("Y-m-d H:i:s"),
                    'tipo' => 'Entrada',
                    'estoqueini' => $qtde_antiga,
                    'quantidade' => $produto_nf['quantidade'],
                    'estoquefi' => $qtde_nova,
                    'cancelada' => ' ',
                    'usuario' => 'compras.hvu'
                );

                $transacaoQ = /** @lang text */
                    "INSERT INTO tbl_transacoes(produto_t, data_t,tipo_t, estoqueini_t,quantidade_t,estoquefi_t,cancelada_t, realizadapor_t)
                VALUES (:produto_t, :data_t,:tipo_t,:estoqueini_t,:quantidade_t,:estoquefi_t,:cancelada_t,:realizadapor_t)";
                $tranSQL = $this->conn->prepare($transacaoQ);
                $tranSQL->bindValue(':produto_t', $transacao['produto']);
                $tranSQL->bindValue(':data_t', $transacao['data']);
                $tranSQL->bindValue(':tipo_t', $transacao['tipo']);
                $tranSQL->bindValue(':estoqueini_t', $transacao['estoqueini']);
                $tranSQL->bindValue(':quantidade_t', $transacao['quantidade']);
                $tranSQL->bindValue(':estoquefi_t', $transacao['estoquefi']);
                $tranSQL->bindValue(':cancelada_t', $transacao['cancelada']);
                $tranSQL->bindValue(':realizadapor_t', $transacao['usuario']);
                $tranSQL->execute();

            }
            $query = /** @lang text */
                "UPDATE tbl_nf SET 
			status_nf=:status_nf
			WHERE id_nf='$idnf'";
            $editar_nf = $this->conn->prepare($query);
            $editar_nf->bindValue(':status_nf', 1);
            $editar_nf->execute();
            return (bool)($this->conn->commit());

        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }
    public function deleteProdNF($id, $item_estoque, $qtde_nf)
    {
        try {
            $this->conn->beginTransaction();
            $qtde_antigasql = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE id_estoque='$item_estoque'");
            $qtde_antigasql->execute();
            $query_result = $qtde_antigasql->fetchAll(PDO::FETCH_OBJ);
            $qtde_nova = 0;
            $qtde_antiga = 0;
            foreach ($query_result as $v) {
                $qtde_antiga = $v->quantidade_e;
                $qtde_nova = $qtde_antiga - $qtde_nf;
            }
            $query = /** @lang text */
                "UPDATE tbl_estoque SET 
			quantidade_e=:quantidade_e
			WHERE id_estoque='$item_estoque'";
            $editar_nf = $this->conn->prepare($query);
            $editar_nf->bindValue(':quantidade_e', $qtde_nova);
            $editar_nf->execute();
            $delete_prod = $this->conn->prepare(/** @lang text */ "DELETE FROM  tbl_itens_nf WHERE id_itens='$id'");
            $delete_prod->execute();
            if ($delete_prod) {
                $this->conn->commit();
            }
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }
    public function listProdNF($nf): array
    {
        $produtosNF = null;
        try {
            $view_nf = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_items_compra
            INNER JOIN tbl_ordem_compra ON tbl_items_compra.ordem_compra_id = tbl_ordem_compra.id_ordem
            INNER JOIN tbl_estoque ON tbl_items_compra.item_compra = tbl_estoque.id_estoque
            WHERE tbl_ordem_compra.id_fk_nf = '$nf'");
            $view_nf->execute();
            $produtosNF = $view_nf->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
        }
        return $produtosNF;
    }
    public function updateProdNF($produto, $idprod)
    {
        try {
            $this->conn->beginTransaction();
            $query = /** @lang text */
                "UPDATE tbl_itens_nf SET 
			lote_e=:lote_e,
			validade_prod_nf=:validade_prod_nf
			WHERE id_itens='$idprod'";
            $editProfnf = $this->conn->prepare($query);
            $editProfnf->bindValue(':lote_e', $produto['lote']);
            $editProfnf->bindValue(':validade_prod_nf', $produto['validade']);
            $editProfnf->execute();
            if ($editProfnf) {
                $this->conn->commit();
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }
    public function storeVencimentoNF($data)
    {
        try {
            $this->conn->beginTransaction();
            $query_Sql = /** @lang text */
                "INSERT INTO tbl_vencimento_boleto(nota_fiscal_id,vencimento) 
                VALUES (:nota_fiscal_id,:vencimento)";
            $sql = $this->conn->prepare($query_Sql);
            $sql->bindValue(':nota_fiscal_id', $data['notaid']);
            $sql->bindValue(':vencimento', $data['vencimento']);
            $sql->execute();
            if ($sql) {
                $this->conn->commit();
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }
    public function listVencimento($id): array
    {
        $vencimento = null;
        try {
            $viewVencimento = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_vencimento_boleto WHERE nota_fiscal_id = '$id'");
            $viewVencimento->execute();
            $vencimento = $viewVencimento->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
        }
        return $vencimento;
    }
    public function deleteVencimento($id)
    {
        try {
            $deleteVencimento = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_vencimento_boleto WHERE id='$id'");
            $deleteVencimento->execute();
        } catch (PDOException $erro) {
        }
    }
    public function storeLoteProdNF($produto)
    {
        try {
            $this->conn->beginTransaction();
            $query_Sql = /** @lang text */
                "INSERT INTO tbl_nf_lotes(id_nf,id_prod,lote,validade) 
                VALUES (:id_nf,:id_prod,:lote,:validade)";
            $sql = $this->conn->prepare($query_Sql);
            $sql->bindValue(':id_nf', $produto['nota-fiscal']);
            $sql->bindValue(':id_prod', $produto['produto']);
            $sql->bindValue(':lote', $produto['lote']);
            $sql->bindValue(':validade', $produto['validade']);
            $sql->execute();
            if ($sql) {
                $this->conn->commit();
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }
    public function deleteLoteProdNF($id)
    {

        try {
            $deleteL = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_nf_lotes WHERE id_nf_lote='$id'");
            $deleteL->execute();
        } catch (PDOException $erro) {
        }
    }
    public function listLote($idnf): array
    {
        $lotes = null;
        try {
            $viewlotes = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque
             INNER JOIN  tbl_nf_lotes ON tbl_nf_lotes.id_prod = tbl_estoque.id_estoque
             WHERE tbl_nf_lotes.id_nf = '$idnf'");
            $viewlotes->execute();
            $lotes = $viewlotes->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
        }
        return $lotes;
    }
    public function listNF(): array
    {
        $notas = null;
        try {
            $view_nf = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_nf INNER JOIN tbl_ordem_compra ON tbl_nf.id_nf = tbl_ordem_compra.id_fk_nf");
            $view_nf->execute();
            $notas = $view_nf->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
        }
        return $notas;
    }


}