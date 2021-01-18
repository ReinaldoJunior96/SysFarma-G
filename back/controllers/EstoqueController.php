<?php
require_once('conexao.php');

class EstoqueController
{
    public $conn = null;

    function __construct()
    {
        $this->conn = PDOconectar::conectar();
    }

    public function newProduto($produto)
    {
        try {
            $this->conn->beginTransaction();
            $queryInsert = /** @lang text */
                "INSERT INTO tbl_estoque(principio_ativo,produto_e,quantidade_e,valor_un_e,estoque_minimo_e,apresentacao,concentracao,forma_farmaceutica,tipo) 
			VALUES (:principio_ativo,:produto_e,:quantidade_e,:valor_un_e,:estoque_minimo_e,:apresentacao,:concentracao,:forma_farmaceutica,:tipo)";
            $insertValues = $this->conn->prepare($queryInsert);
            $insertValues->bindValue(':principio_ativo', $produto['p_ativo']);
            $insertValues->bindValue(':produto_e', $produto['produto']);
            $insertValues->bindValue(':quantidade_e', $produto['quantidade']);
            $insertValues->bindValue(':valor_un_e', $produto['valor']);
            $insertValues->bindValue(':estoque_minimo_e', $produto['estoque_minimo_e']);
            $insertValues->bindValue(':apresentacao', $produto['apresentacao']);
            $insertValues->bindValue(':concentracao', $produto['concentracao']);
            $insertValues->bindValue(':forma_farmaceutica', $produto['forma_farmaceutica']);
            $insertValues->bindValue(':tipo', $produto['tipo']);
            $insertValues->execute();
            if ($insertValues) {
                $this->conn->commit();
                echo "<script language=\"javascript\">window.history.back();</script>";
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro ao cadastrar produto!!\")</script>";
            echo "<script language=\"javascript\">window.history.back();</script>";
        }
    }

    public function editProduto($produto, $id)
    {
        try {
            $qtdeAntiga = 0;
            $this->conn->beginTransaction();
            $buscarQtdeAntiga = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE id_estoque='$id'");
            $buscarQtdeAntiga->execute();
            $queryResult = $buscarQtdeAntiga->fetchAll(PDO::FETCH_OBJ);
            foreach ($queryResult as $v) {
                $qtdeAntiga = $v->quantidade_e;
            }
            $queryUpdate = /** @lang text */
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
            $newValue = $this->conn->prepare($queryUpdate);
            $newValue->bindValue(':principio_ativo', $produto['p_ativo']);
            $newValue->bindValue(':produto_e', $produto['produto']);
            $newValue->bindValue(':quantidade_e', $produto['quantidade']);
            $newValue->bindValue(':valor_un_e', $produto['valor']);
            $newValue->bindValue(':estoque_minimo_e', $produto['estoque_minimo_e']);
            $newValue->bindValue(':apresentacao', $produto['apresentacao']);
            $newValue->bindValue(':concentracao', $produto['concentracao']);
            $newValue->bindValue(':forma_farmaceutica', $produto['forma_farmaceutica']);
            $newValue->execute();
            if ($newValue) {
                $this->conn->commit();
                if ($qtdeAntiga != $produto['quantidade']) {
                    date_default_timezone_set('America/Sao_Paulo');
                    $transacao = array(
                        'produto' => $id,
                        'data' => date("Y-m-d H:i:s"),
                        'tipo' => 'Ajuste de Estoque',
                        'estoqueini' => $qtdeAntiga,
                        'quantidade' => ($produto['quantidade'] >= $qtdeAntiga) ? $produto['quantidade'] - $qtdeAntiga : $qtdeAntiga - $produto['quantidade'],
                        'estoquefi' => $produto['quantidade'],
                        'cancelada' => ' ',
                        'user' => $produto['user']
                    );
                    self::transacaoRegistro($transacao);
                }
                echo "<script language=\"javascript\">window.history.back();</script>";
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro ao alterar produto!!\")</script>";
        }
    }

    public function verEstoqueTotal()
    {
        try {
            $queryBuscaEstoque = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE produto_e!=''");
            $queryBuscaEstoque->execute();
            return $queryBuscaEstoque->fetchAll(PDO::FETCH_OBJ);
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
            $queryBuscaEstoque = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE tipo='material'");
            $queryBuscaEstoque->execute();
            return $queryBuscaEstoque->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar produtos!!\")</script>";
        }
    }

    public function estoqueID($id)
    {
        try {
            $queryBuscaProduto = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE id_estoque='$id'");
            $queryBuscaProduto->execute();
            return $queryBuscaProduto->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar produtos!!\")</script>";
        }
    }

    public function gerarRelatorio($setor, $dataI, $dataF)
    {
        try {
            $buscarRelatorio = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_saida
            INNER JOIN tbl_estoque ON tbl_saida.item_s = tbl_estoque.id_estoque
            WHERE setor_s='$setor'
            AND data_dia_s BETWEEN '$dataI' AND '$dataF' ORDER BY item_s ASC");
            $buscarRelatorio->execute();
            return $buscarRelatorio->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao gerar relatório!!\")</script>";
        }
    }

    public function relatorioGeral($dataI, $dataF)
    {
        try {
            $buscarRelatorio = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_saida
            INNER JOIN tbl_estoque ON tbl_saida.item_s = tbl_estoque.id_estoque
            WHERE data_dia_s BETWEEN '$dataI' AND '$dataF' ORDER BY item_s ASC");
            $buscarRelatorio->execute();
            return $buscarRelatorio->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao gerar relatório!!\")</script>";
        }
    }

    public function destroyProduto($id)
    {
        try {
            $deleteProduto = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_estoque WHERE id_estoque='$id'");
            $deleteProduto->execute();
        } catch (PDOException $erro) {
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
            if ($insertValues) {
                $this->conn->commit();
            }
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
            $deleteFornecedor = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_prod_fornecedor WHERE idfp='$id'");
            $deleteFornecedor->execute();
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao remover produto \")</script>";
        }
    }

    public function transacaoRegistro($dados)
    {
        try {
            $this->conn->beginTransaction();
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
            $tranSQL->bindValue(':realizadapor_t', $dados['user']);
            $tranSQL->execute();
            if ($tranSQL) {
                $this->conn->commit();
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro ao registrar transacao\")</script>";
        }
    }

    public function searchTransacoes($prod)
    {
        try {
            $search = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_transacoes           
                WHERE produto_t='$prod'
                ORDER BY data_t DESC LIMIT 0,30");
            $search->execute();
            return $search->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao listar produto\")</script>";
        }
    }


    public function registrarSaida($saida)
    {
        try {
            $this->conn->beginTransaction();
            $query_Sql = /** @lang text */
                "INSERT INTO tbl_saida(item_s,quantidade_s,setor_s,data_s,data_dia_s) VALUES (:item_s,:quantidade_s,:setor_s,:data_s,:data_dia_s)";
            $sql = $this->conn->prepare($query_Sql);
            $sql->bindValue(':item_s', $saida['produto']);
            $sql->bindValue(':quantidade_s', $saida['quantidade']);
            $sql->bindValue(':setor_s', $saida['setor']);
            $sql->bindValue(':data_s', $saida['data']);
            $sql->bindValue(':data_dia_s', $saida['data']);
            $sql->execute();
            $produto = $saida['produto'];
            $qtde_antiga = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE id_estoque='$produto'");
            $qtde_antiga->execute();
            $query_result = $qtde_antiga->fetchAll(PDO::FETCH_OBJ);
            $qtde_nova = 0;
            foreach ($query_result as $v) {
                $qtde_antiga = $v->quantidade_e;
                $qtde_nova = $qtde_antiga - $saida['quantidade'];
                $produtoNome = $v->produto_e;
            }
            if ($saida['quantidade'] > $qtde_antiga) {
                echo "<script language=\"javascript\">alert(\"Quantidade solicitada é maior que a quantidade em estoque\")</script>";
            } else {
                $alterar_estoque = /** @lang text */
                    "UPDATE tbl_estoque SET quantidade_e=:quantidade WHERE id_estoque='$produto'";
                $fazer_alteracao = $this->conn->prepare($alterar_estoque);
                $fazer_alteracao->bindValue(':quantidade', $qtde_nova);
                $fazer_alteracao->execute();
                if ($fazer_alteracao) {
                    $this->conn->commit();
                    /* transacao */
                    date_default_timezone_set('America/Sao_Paulo');
                    $hora = new DateTime();
                    $transacao = array(
                        'produto' => $saida['produto'],
                        'data' => date("Y-m-d H:i:s"),
                        'tipo' => 'Saída',
                        'estoqueini' => $qtde_antiga,
                        'quantidade' => $saida['quantidade'],
                        'estoquefi' => $qtde_nova,
                        'cancelada' => ' ',
                        'user' => $saida['user']
                    );
                    $registrarTransaocao = new EstoqueController();
                    $registrarTransaocao->transacaoRegistro($transacao);
                    echo "<script language=\"javascript\">alert(\"Saída Registrada\")</script>";
                }
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }

    public function historicoSaida()
    {
        try {
            $historicoSaida = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_saida
				INNER JOIN tbl_estoque ON tbl_saida.item_s = tbl_estoque.id_estoque 
				ORDER BY tbl_saida.id_saida DESC LIMIT 0,5000");
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
				ORDER BY tbl_saida.id_saida DESC LIMIT 0,500");
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
            $buscarProd = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_estoque WHERE id_estoque=$prod");
            $buscarProd->execute();
            $queryResult = $buscarProd->fetchAll(PDO::FETCH_OBJ);
            foreach ($queryResult as $p) {
                $qtdeA = $p->quantidade_e;
            }
            $queryEdit = /** @lang text */
                "UPDATE tbl_estoque SET quantidade_e=:quantidade WHERE id_estoque='$prod'";
            $voltarQtde = $this->conn->prepare($queryEdit);
            $voltarQtde->bindValue(':quantidade', $qtdeA + $qtde);
            $voltarQtde->execute();
            $deleteSaida = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_saida WHERE id_saida='$id'");
            $deleteSaida->execute();

            date_default_timezone_set('America/Sao_Paulo');
            $transacao = array(
                'produto' => $prod,
                'data' => date("Y-m-d H:i:s"),
                'tipo' => 'Saída',
                'estoqueini' => $qtdeA,
                'quantidade' => $qtde,
                'estoquefi' => $qtdeA + $qtde,
                'cancelada' => 'Sim',
                'user' => $user
            );
            self::transacaoRegistro($transacao);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }
}