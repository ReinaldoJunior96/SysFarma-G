<?php
require_once('EstoqueController.php');
require_once('conexao.php');
date_default_timezone_set('America/Sao_Paulo');

class AvariaController
{
    public $conn = null;
    public $data = null;
    public $estoqueClass = null;

    function __construct()
    {
        $this->conn = PDOconectar::conectar();
        $this->data = new DateTime('NOW');
        $this->estoqueClass = new EstoqueController();
    }

    public function storePA($produto): int
    {
        try {
            $statusErro = 0;
            /* Se entrar no if é pq a quantidade em estoque é menor que a quantidade de avaria (soliticatada)*/
            if ($this->estoqueClass->verificarQuantidade($produto['produtoavaria'], $produto['quantidadeavaria'], 0) == 1):
                $statusErro = 1;
            else:
                $this->conn->beginTransaction();
                $cadastroQuery = /** @lang text * */
                    "INSERT INTO tbl_avaria(produto_avaria,quantidade_avaria,lote_avaria,vencimento_avaria,obs_avaria,data_cadastro) 
                VALUES (:produto_avaria,:quantidade_avaria,:lote_avaria,:vencimento_avaria,:obs_avaria,:data_cadastro)";
                $sql = $this->conn->prepare($cadastroQuery);
                $sql->bindValue(':produto_avaria', $produto['produtoavaria']);
                $sql->bindValue(':quantidade_avaria', $produto['quantidadeavaria']);
                $sql->bindValue(':lote_avaria', $produto['loteavaria']);
                $sql->bindValue(':vencimento_avaria', $produto['validadeavaria']);
                $sql->bindValue(':obs_avaria', $produto['obsavaria']);
                $sql->bindValue(':data_cadastro', date_format($this->data, 'Y-m-d H:i:s'));
                $sql->execute();
                if ($sql) {
                    $this->conn->commit();
                    self::deleteQtdeInEstoque($produto['produtoavaria'], $produto['quantidadeavaria'], $produto['usuario']);
                }
            endif;
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
        return $statusErro;
    }

    public function deleteQtdeInEstoque($produto, $quantidade, $user)
    {
        try {
            $emEstoque = $this->estoqueClass->verificarQuantidade($produto, $quantidade, 1);
            $this->conn->beginTransaction();
            $alteraQuantidadeSQL = /** @lang text * */
                "UPDATE tbl_estoque SET quantidade_e=:quantidade WHERE id_estoque='$produto'";
            $queryExecute = $this->conn->prepare($alteraQuantidadeSQL);
            $queryExecute->bindValue(':quantidade', $emEstoque - $quantidade);
            $queryExecute->execute();
            if ($queryExecute) {
                $this->conn->commit();
                /* transacao */
                $arrayTempTransacao = array(
                    'produto' => $produto,
                    'data' => date_format($this->data, 'Y-m-d H:i:s'),
                    'tipo' => 'Avaria/Vencido',
                    'estoqueini' => $emEstoque,
                    'quantidade' => $quantidade,
                    'estoquefi' => $emEstoque - $quantidade,
                    'cancelada' => ' ',
                    'usuario' => $user
                );
                $this->estoqueClass->transacaoRegistro($arrayTempTransacao);
            }
        } catch
        (PDOException $erro) {
            $this->conn->rollBack();
        }
    }

    public function listPA(): array
    {
        $querySelect = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_avaria 
        INNER JOIN tbl_estoque 
        ON tbl_avaria.produto_avaria = tbl_estoque.id_estoque");
        $querySelect->execute();
        return $querySelect->fetchAll(PDO::FETCH_OBJ);
    }

    public function listUniquePA($idAvaria): array
    {
        $querySelect = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_avaria WHERE id_avaria='$idAvaria'");
        $querySelect->execute();
        return $querySelect->fetchAll(PDO::FETCH_OBJ);
    }

    public function deletePA($idAvaria, $user): int
    {
        $produtoID = null;
        $qtdeAvaria = null;
        $erroLocalDelete = 0;
        try {
            $dadosAvaria = self::listUniquePA($idAvaria);
            $produtoID = $dadosAvaria[0]->produto_avaria;
            $qtdeAvaria = $dadosAvaria[0]->quantidade_avaria;
            if (self::returnQtdeForEstoque($produtoID, $qtdeAvaria, $user) == 1):
                $deleteAvaria = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_avaria WHERE id_avaria='$idAvaria'");
                $deleteAvaria->execute();
            else:
                $erroLocalDelete = 1;
            endif;
        } catch (PDOException $erroExp) {
        }
        return $erroLocalDelete;
    }

    public function returnQtdeForEstoque($produto, $quantidade, $user): int
    {
        $inEstqoue = null;
        $status = null;
        try {
            $produtoEstoque = $this->estoqueClass->estoqueID($produto);
            foreach ($produtoEstoque as $v):
                $inEstqoue = $v->quantidade_e;
            endforeach;
            $this->conn->beginTransaction();
            $alteraQuantidadeSQL = /** @lang text * */
                "UPDATE tbl_estoque SET quantidade_e=:quantidade WHERE id_estoque='$produto'";
            $queryExecute = $this->conn->prepare($alteraQuantidadeSQL);
            $queryExecute->bindValue(':quantidade', $inEstqoue + $quantidade);
            $queryExecute->execute();
            if ($queryExecute) {
                $this->conn->commit();
                $arrayTempTransacao = array(
                    'produto' => $produto,
                    'data' => date_format($this->data, 'Y-m-d H:i:s'),
                    'tipo' => 'Avaria/Vencido',
                    'estoqueini' => $inEstqoue,
                    'quantidade' => $quantidade,
                    'estoquefi' => $inEstqoue + $quantidade,
                    'cancelada' => 'Sim',
                    'usuario' => $user
                );
                $this->estoqueClass->transacaoRegistro($arrayTempTransacao);
                $status = 1;
            }

        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
        return $status;
    }
}