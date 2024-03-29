<?php
require_once 'conexao.php';
date_default_timezone_set('America/Sao_Paulo');

class EstoqueController
{
    public $conn = null;

    public function __construct()
    {
        $this->conn = PDOconectar::conectar();
    }

    public function newProduto($produto)
    {
        try {
            $this->conn->beginTransaction();
            $inserirProdutoQuery = /** @lang text */
                "INSERT INTO tbl_estoque(principio_ativo,produto_e,quantidade_e,valor_un_e,estoque_minimo_e,apresentacao,concentracao,forma_farmaceutica,tipo)
			VALUES (:principio_ativo,:produto_e,:quantidade_e,:valor_un_e,:estoque_minimo_e,:apresentacao,:concentracao,:forma_farmaceutica,:tipo)";
            $executeInserirProd = $this->conn->prepare($inserirProdutoQuery);
            $executeInserirProd->bindValue(':principio_ativo', $produto['p_ativo']);
            $executeInserirProd->bindValue(':produto_e', $produto['produto']);
            $executeInserirProd->bindValue(':quantidade_e', $produto['quantidade']);
            $executeInserirProd->bindValue(':valor_un_e', $produto['valor']);
            $executeInserirProd->bindValue(':estoque_minimo_e', $produto['estoque_minimo_e']);
            $executeInserirProd->bindValue(':apresentacao', $produto['apresentacao']);
            $executeInserirProd->bindValue(':concentracao', $produto['concentracao']);
            $executeInserirProd->bindValue(':forma_farmaceutica', $produto['forma_farmaceutica']);
            $executeInserirProd->bindValue(':tipo', $produto['tipo']);
            $executeInserirProd->execute();
            $this->conn->commit();
            echo "<script language=\"javascript\">window.history.back();</script>";
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro ao cadastrar produto!!\")</script>";
            echo "<script language=\"javascript\">window.history.back();</script>";
        }
    }

    public function editProduto($produto, $id)
    {
        try {
            $varAuxEdit = 0;

            $this->conn->beginTransaction();
            $buscarProdutoQuery = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE id_estoque='$id'");
            $buscarProdutoQuery->execute();
            $produtoResult = $buscarProdutoQuery->fetchAll(PDO::FETCH_OBJ);
            $varAuxEdit = $produtoResult[0]->quantidade_e;

            $updateProdutoQuery = /** @lang text */
                "UPDATE tbl_estoque SET
            principio_ativo=:principio_ativo,
			produto_e=:produto_e,
			quantidade_e=:quantidade_e,
			valor_un_e=:valor_un_e,
			estoque_minimo_e=:estoque_minimo_e,
			apresentacao=:apresentacao,
			concentracao=:concentracao,
			forma_farmaceutica=:forma_farmaceutica
			WHERE id_estoque='$id'";

            $executeUpdateProd = $this->conn->prepare($updateProdutoQuery);
            $executeUpdateProd->bindValue(':principio_ativo', $produto['p_ativo']);
            $executeUpdateProd->bindValue(':produto_e', $produto['produto']);
            $executeUpdateProd->bindValue(':quantidade_e', $produto['quantidade']);
            $executeUpdateProd->bindValue(':valor_un_e', $produto['valor']);
            $executeUpdateProd->bindValue(':estoque_minimo_e', $produto['estoque_minimo_e']);
            $executeUpdateProd->bindValue(':apresentacao', $produto['apresentacao']);
            $executeUpdateProd->bindValue(':concentracao', $produto['concentracao']);
            $executeUpdateProd->bindValue(':forma_farmaceutica', $produto['forma_farmaceutica']);
            $executeUpdateProd->execute();

            if ($varAuxEdit != $produto['quantidade']) {
                $transacao = array(
                    'produto' => $id,
                    'data' => date("Y-m-d H:i:s"),
                    'tipo' => 'Ajuste de Estoque',
                    'estoqueini' => $varAuxEdit,
                    'quantidade' => ($produto['quantidade'] >= $varAuxEdit) ? $produto['quantidade'] - $varAuxEdit : $varAuxEdit - $produto['quantidade'],
                    'estoquefi' => $produto['quantidade'],
                    'cancelada' => ' ',
                    'usuario' => $produto['usuario'],
                );
                self::transacaoRegistro($transacao);
            }
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }

    public function verEstoqueTotal()
    {
        try {
            $buscarEstoqueQuery = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE produto_e!=''");
            $buscarEstoqueQuery->execute();
            return $buscarEstoqueQuery->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar produtos!!\")</script>";
        }
    }

    public function verEstoqueFarmacia()
    {
        try {
            $queryBuscaEstoque = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE tipo='0' AND produto_e!='' ORDER BY produto_e ASC");
            $queryBuscaEstoque->execute();
            return $queryBuscaEstoque->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar produtos!!\")</script>";
        }
    }

    public function verEstoqueFarmaciaSaida()
    {
        try {
            $queryBuscaEstoque = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE tipo='0' AND produto_e != '' AND quantidade_e != '' ORDER BY produto_e ASC");
            $queryBuscaEstoque->execute();
            return $queryBuscaEstoque->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar produtos!!\")</script>";
        }
    }

    public function verProdDiversos()
    {
        try {
            $queryBuscaEstoque = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE tipo='material' AND produto_e != ''");
            $queryBuscaEstoque->execute();
            return $queryBuscaEstoque->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar produtos!!\")</script>";
        }
    }

    public function estoqueID($id): array
    {
        try {
            $queryBuscaProduto = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE id_estoque='$id'");
            $queryBuscaProduto->execute();
            return $queryBuscaProduto->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar produtos!!\")</script>";
        }
    }

    public function destroyProduto($id)
    {
        try {
            $this->conn->beginTransaction();
            $deleteProduto = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_estoque WHERE id_estoque='$id'");
            $deleteProduto->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro ao excluir produto!!\")</script>";
        }
    }

    public function historicoProd($id)
    {
        try {
            $buscaHistorico = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_items_compra
                INNER JOIN tbl_ordem_compra ON tbl_items_compra.ordem_compra_id = tbl_ordem_compra.id_ordem
                INNER JOIN tbl_nf ON tbl_ordem_compra.id_fk_nf = tbl_nf.id_nf
                WHERE tbl_items_compra.item_compra='$id'
                ORDER BY tbl_nf.data_emissao DESC");
            $buscaHistorico->execute();
            return $buscaHistorico->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar historico\")</script>";
        }
    }

    public function historicoLote($idprod)
    {
        try {
            $buscarLote = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque
                INNER JOIN tbl_nf_lotes ON tbl_estoque.id_estoque = tbl_nf_lotes.id_prod
                WHERE tbl_nf_lotes.id_prod='$idprod'
                ORDER BY tbl_nf_lotes.validade DESC");
            $buscarLote->execute();
            return $buscarLote->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar lotes\")</script>";
        }
    }

    public function fornecedorProduto($produto, $fornecedor)
    {
        try {
            $this->conn->beginTransaction();
            $queryInsert = /** @lang text */
                "INSERT INTO tbl_prod_fornecedor(idfornecedor,idproduto) VALUES (:idfornecedor,:idproduto)";
            $insertValues = $this->conn->prepare($queryInsert);
            $insertValues->bindValue(':idfornecedor', $fornecedor);
            $insertValues->bindValue(':idproduto', $produto);
            $insertValues->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }

    public function searchFornecedorProduto($prod)
    {
        try {
            $search = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_fornecedores
                INNER JOIN tbl_prod_fornecedor ON tbl_fornecedores.id_fornecedor = tbl_prod_fornecedor.idfornecedor
                WHERE tbl_prod_fornecedor.idproduto='$prod'
                ORDER BY tbl_fornecedores.nome_fornecedor ASC");
            $search->execute();
            return $search->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }

    public function removeFornecedorProd($id)
    {
        try {
            $this->conn->beginTransaction();
            $deleteFornecedor = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_prod_fornecedor WHERE idfp='$id'");
            $deleteFornecedor->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro ao remover produto \")</script>";
        }
    }


    public function searchTransacoes($prod)
    {
        try {
            $search = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_transacoes
                WHERE produto_t='$prod' ORDER BY data_t DESC");
            $search->execute();
            return $search->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar produto\")</script>";
        }
    }

    public function historicoSaida()
    {
        try {
            $historicoSaida = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_saida
				INNER JOIN tbl_estoque ON tbl_saida.item_s = tbl_estoque.id_estoque
				ORDER BY tbl_saida.id_saida DESC LIMIT 0,2500");
            $historicoSaida->execute();
            return $historicoSaida->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar historico\")</script>";
        }
    }

    public function filtroHistorico($setor)
    {
        try {
            $historicoSaida = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_saida
				INNER JOIN tbl_estoque ON tbl_saida.item_s = tbl_estoque.id_estoque
				WHERE setor_s = '$setor'
				ORDER BY tbl_saida.id_saida DESC LIMIT 0,2500");
            $historicoSaida->execute();
            return $historicoSaida->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar historico\")</script>";
        }
    }

    public function cancelarSaida($id, $prod, $qtde, $user)
    {
        try {

            $qtdeA = 0;

            $produtoInEstoque = self::estoqueID($prod);
            $qtdeA = $produtoInEstoque[0]->quantidade_e;

            $this->conn->beginTransaction();

            $queryEdit = /** @lang text */
                "UPDATE tbl_estoque SET quantidade_e=:quantidade WHERE id_estoque='$prod'";
            $voltarQtde = $this->conn->prepare($queryEdit);
            $voltarQtde->bindValue(':quantidade', $qtdeA + $qtde);
            $voltarQtde->execute();

            $deleteSaida = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_saida WHERE id_saida='$id'");
            $deleteSaida->execute();

            $transacao = array(
                'produto' => $prod,
                'data' => date("Y-m-d H:i:s"),
                'tipo' => 'Saída',
                'estoqueini' => $qtdeA,
                'quantidade' => $qtde,
                'estoquefi' => $qtdeA + $qtde,
                'cancelada' => 'Sim',
                'usuario' => $user,
            );
            self::transacaoRegistro($transacao);

            $this->conn->commit();

        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }

    public function searchDevolucao($id)
    {
        try {
            $historicoSaida = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_saida
				INNER JOIN tbl_estoque ON tbl_saida.item_s = tbl_estoque.id_estoque
				WHERE tbl_saida.id_saida = '$id'");
            $historicoSaida->execute();
            return $historicoSaida->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar historico\")</script>";
        }
    }

    public function registrarDevolucao($request)
    {
        try {
            $produtoID = $request['itemsaida'];
            $produto = "";
            $quantidadeInicial = 0;

            $buscarProd = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE id_estoque=$produtoID");
            $buscarProd->execute();
            $queryResult = $buscarProd->fetchAll(PDO::FETCH_OBJ);
            foreach ($queryResult as $p) {
                $produto = array(
                    'idp' => $produtoID,
                    'nomep' => $p->produto_e,
                    'quatidadef' => $p->quantidade_e + $request['quantidadedevolvida'],
                    'valorunitario' => $p->valor_un_e,
                    'estoqueminimo' => $p->estoque_minimo_e,
                    'apresentacao' => $p->apresentacao,
                    'concentracao' => $p->concentracao,
                    'formaf' => $p->forma_farmaceutica,
                    'principio' => $p->principio_ativo,
                    'tipo' => $p->tipo,
                );
                $quantidadeInicial = $p->quantidade_e;
            }

            if ($request['quantidadedevolvida'] > $request['quantidadesaida']) {
                echo "<script language=\"javascript\">alert(\"Quantidade devolvida é maior que a saída!!\")</script>";
                echo "<script language=\"javascript\">window.history.back();</script>";
            } elseif ($request['quantidadedevolvida'] == $request['quantidadesaida']) {
                echo "<script language=\"javascript\">alert(\"Quantidades iguais, cancele a saída!!\")</script>";
                echo "<script language=\"javascript\">window.history.back();</script>";
            } elseif ($request['quantidadedevolvida'] <= 0) {
                echo "<script language=\"javascript\">alert(\"Quantidade Inválida\")</script>";
                echo "<script language=\"javascript\">window.history.back();</script>";
            } elseif (($request['quantidadedevolvida'] < $request['quantidadesaida']) && ($request['quantidadedevolvida'] > 0)) {
                self::editProdutoDevolucao($produto);

                $idsaida = $request['idsaida'];

                $this->conn->beginTransaction();
                $queryUpdate = /** @lang text * */
                    "UPDATE tbl_saida SET
            item_s=:item_s,
            quantidade_s=:quantidade_s,
            setor_s=:setor_s,
            data_s=:data_s,
            data_dia_s=:data_dia_s
			WHERE id_saida='$idsaida'";
                $newValue = $this->conn->prepare($queryUpdate);
                $newValue->bindValue(':item_s', $request['itemsaida']);
                $newValue->bindValue(':quantidade_s', $request['quantidadesaida'] - $request['quantidadedevolvida']);
                $newValue->bindValue(':setor_s', $request['setorsaida']);
                $newValue->bindValue(':data_s', $request['datas']);
                $newValue->bindValue(':data_dia_s', $request['datadiasaida']);
                $newValue->execute();

                $transacao = array(
                    'produto' => $request['itemsaida'],
                    'data' => date("Y-m-d H:i:s"),
                    'tipo' => 'Devolução',
                    'estoqueini' => $quantidadeInicial,
                    'quantidade' => $request['quantidadedevolvida'],
                    'estoquefi' => $quantidadeInicial + $request['quantidadedevolvida'],
                    'cancelada' => ' ',
                    'usuario' => $request['usuario']);

                self::transacaoRegistro($transacao);

                $this->conn->commit();

                header("location: ../../../views/cadastro-saida/list-historico.php?status=ok");
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro ao alterar produto!!\")</script>";
        }
    }

    public function editProdutoDevolucao($produto)
    {
        try {
            $this->conn->beginTransaction();
            $idproduto = $produto['idp'];
            $queryUpdateProduto = /** @lang text */
                "UPDATE tbl_estoque SET
            principio_ativo=:principio_ativo,
			produto_e=:produto_e,
			quantidade_e=:quantidade_e,
			valor_un_e=:valor_un_e,
			estoque_minimo_e=:estoque_minimo_e,
			apresentacao=:apresentacao,
			concentracao=:concentracao,
			forma_farmaceutica=:forma_farmaceutica,
			tipo=:tipo
			WHERE id_estoque='$idproduto'";
            $newValue = $this->conn->prepare($queryUpdateProduto);
            $newValue->bindValue(':principio_ativo', $produto['principio']);
            $newValue->bindValue(':produto_e', $produto['nomep']);
            $newValue->bindValue(':quantidade_e', $produto['quatidadef']);
            $newValue->bindValue(':valor_un_e', $produto['valorunitario']);
            $newValue->bindValue(':estoque_minimo_e', $produto['estoqueminimo']);
            $newValue->bindValue(':apresentacao', $produto['apresentacao']);
            $newValue->bindValue(':concentracao', $produto['concentracao']);
            $newValue->bindValue(':forma_farmaceutica', $produto['formaf']);
            $newValue->bindValue(':tipo', $produto['tipo']);
            $newValue->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }

    public function verificarSaidaConsumo($produto, $dataI, $dataF): int
    {
        $quantidadeSaida = 0;
        try {
            $querySaida = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_saida
				WHERE item_s = '$produto' AND data_dia_s BETWEEN '$dataI' AND '$dataF'");
            $querySaida->execute();
            $quantidadeSaida = $querySaida->rowCOunt();
        } catch (PDOException $erro) {
        }
        return $quantidadeSaida;
    }

    public function rconsumo($setor, $dataI, $dataF, $idproduto): array
    {
        try {
            $querySearchRelatorio = "";

            if ($setor == 'todos'):
                $querySearchRelatorio = $this->conn->prepare(/** @lang text */ "SELECT SUM(quantidade_s) as somatorio,produto_e FROM tbl_saida
												            INNER JOIN tbl_estoque ON tbl_saida.item_s = tbl_estoque.id_estoque
												            WHERE item_s='$idproduto' AND data_dia_s BETWEEN '$dataI' AND '$dataF' ORDER BY tbl_estoque.produto_e ASC");
            else:
                $querySearchRelatorio = $this->conn->prepare(/** @lang text */ "SELECT SUM(quantidade_s) as somatorio,produto_e FROM tbl_saida
												            INNER JOIN tbl_estoque ON tbl_saida.item_s = tbl_estoque.id_estoque
												            WHERE item_s='$idproduto' AND setor_s='$setor' AND data_dia_s BETWEEN '$dataI' AND '$dataF' ORDER BY tbl_estoque.produto_e ASC");
            endif;
            $querySearchRelatorio->execute();
            return $querySearchRelatorio->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
        }
    }

    /* relatório de consumo */
    public function relatorioConsumo($setor, $dataI, $dataF, $idproduto)
    {
        try {
            $querySearchRelatorio = "";
            if ($setor == 'todos'):
                $querySearchRelatorio = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_saida
												            INNER JOIN tbl_estoque ON tbl_saida.item_s = tbl_estoque.id_estoque
												            WHERE item_s='$idproduto' AND data_dia_s BETWEEN '$dataI' AND '$dataF' ORDER BY tbl_estoque.produto_e ASC");
            else:
                $querySearchRelatorio = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_saida
												            INNER JOIN tbl_estoque ON tbl_saida.item_s = tbl_estoque.id_estoque
												            WHERE item_s='$idproduto' AND setor_s='$setor' AND data_dia_s BETWEEN '$dataI' AND '$dataF' ORDER BY tbl_estoque.produto_e ASC");
            endif;
            $querySearchRelatorio->execute();
            return $querySearchRelatorio->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao gerar relatório!!\")</script>";
        }
    }

    public function inserirSaida($dadosSaida)
    {
        try {
            $this->conn->beginTransaction();
            $query_Sql = /** @lang text */
                "INSERT INTO tbl_saida(item_s,quantidade_s,setor_s,data_s,data_dia_s) VALUES (:item_s,:quantidade_s,:setor_s,:data_s,:data_dia_s)";
            $sql = $this->conn->prepare($query_Sql);
            $sql->bindValue(':item_s', $dadosSaida['produto']);
            $sql->bindValue(':quantidade_s', $dadosSaida['quantidade']);
            $sql->bindValue(':setor_s', $dadosSaida['setores']);
            $sql->bindValue(':data_s', $dadosSaida['data']);
            $sql->bindValue(':data_dia_s', $dadosSaida['data']);
            $sql->execute();

            $produtoSearch = self::estoqueID($dadosSaida['produto']);
            $produtoIDSaida = $dadosSaida['produto'];
            $queryQuantidadeSQL = /** @lang text */
                "UPDATE tbl_estoque SET quantidade_e=:quantidade WHERE id_estoque='$produtoIDSaida'";
            $alterarQtde = $this->conn->prepare($queryQuantidadeSQL);
            $alterarQtde->bindValue(':quantidade', $produtoSearch[0]->quantidade_e - $dadosSaida['quantidade']);
            $alterarQtde->execute();

            $transacao = array(
                'produto' => $dadosSaida['produto'],
                'data' => date("Y-m-d H:i:s"),
                'tipo' => 'Saída',
                'estoqueini' => $produtoSearch[0]->quantidade_e,
                'quantidade' => $dadosSaida['quantidade'],
                'estoquefi' => $produtoSearch[0]->quantidade_e - $dadosSaida['quantidade'],
                'cancelada' => ' ',
                'usuario' => $dadosSaida['usuario'],
            );
            self::transacaoRegistro($transacao);

            $this->conn->commit();

        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }

    public function relatorioPontoCompra(): array
    {
        try {
            $produtosPontoCompra = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque
                WHERE quantidade_e <= estoque_minimo_e ORDER BY tbl_estoque.produto_e ASC");
            $produtosPontoCompra->execute();
            return $produtosPontoCompra->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar produto\")</script>";
        }
    }

    public function controleVencimento(): array
    {
        try {
            $medicamentosVencidos = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_nf_lotes
            INNER JOIN tbl_estoque ON tbl_nf_lotes.id_prod = tbl_estoque.id_estoque WHERE tbl_estoque.tipo = 0 ORDER BY tbl_nf_lotes.validade ASC");
            $medicamentosVencidos->execute();
            return $medicamentosVencidos->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
        }
    }


    public function transacaoRegistro($dados)
    {
        $transacaoQuery = /** @lang text */
            "INSERT INTO tbl_transacoes(produto_t, data_t,tipo_t, estoqueini_t,quantidade_t,estoquefi_t,cancelada_t, realizadapor_t)
                VALUES (:produto_t, :data_t,:tipo_t,:estoqueini_t,:quantidade_t,:estoquefi_t,:cancelada_t,:realizadapor_t)";
        $tranSQL = $this->conn->prepare($transacaoQuery);
        $tranSQL->bindValue(':produto_t', $dados['produto']);
        $tranSQL->bindValue(':data_t', $dados['data']);
        $tranSQL->bindValue(':tipo_t', $dados['tipo']);
        $tranSQL->bindValue(':estoqueini_t', $dados['estoqueini']);
        $tranSQL->bindValue(':quantidade_t', $dados['quantidade']);
        $tranSQL->bindValue(':estoquefi_t', $dados['estoquefi']);
        $tranSQL->bindValue(':cancelada_t', $dados['cancelada']);
        $tranSQL->bindValue(':realizadapor_t', $dados['usuario']);
        $tranSQL->execute();
    }
}
