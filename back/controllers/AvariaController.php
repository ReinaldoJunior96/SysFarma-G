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

    /**
     * Início do cadastro de um produto avariado, após cadastrado é retirado a qtde do estoque
     * @param $produto array
     * Retorna um int se mantendo em 0, caso não tenha erro
     * @return int
     */
    public function novoProdudoAvariado($produto)
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
                    self::removerQuantidadeAvaria($produto['produtoavaria'], $produto['quantidadeavaria'], $produto['user']);
                }
            endif;
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
        return $statusErro;
    }

    /**Método apenas remove a quantidade do estoque de acordo com a avaria inserinda
     * @param $produto int
     * @param $quantidade int
     * @param $user string
     */
    public function removerQuantidadeAvaria($produto, $quantidade, $user)
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
                    'user' => $user
                );
                $this->estoqueClass->transacaoRegistro($arrayTempTransacao);
            }
        } catch
        (PDOException $erro) {
            $this->conn->rollBack();
        }
    }

    /**Busca todos produtos avariados fazendo um innerjoin para pegar o nome dos produtos
     * @return array
     */

    public function buscarProdutoAvariados()
    {
        $querySelect = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_avaria 
        INNER JOIN tbl_estoque 
        ON tbl_avaria.produto_avaria = tbl_estoque.id_estoque");
        $querySelect->execute();
        return $querySelect->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Busca apenas um produto avariado de acordo com o id
     * @param $idAvaria int
     * @return array
     */
    public function buscarAvariasID($idAvaria)
    {
        $querySelect = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_avaria WHERE id_avaria='$idAvaria'");
        $querySelect->execute();
        return $querySelect->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Método de início do delete da avaria
     * @param $idAvaria integer
     * @param $user
     * @return int|null
     */
    public function destroyAvaria($idAvaria, $user)
    {
        $produtoID = null;
        $qtdeAvaria = null;
        $erroLocalDelete = null;
        try {
            $dadosAvaria = self::buscarAvariasID($idAvaria);
            foreach ($dadosAvaria as $k):
                $produtoID = $k->produto_avaria;
                $qtdeAvaria = $k->quantidade_avaria;
            endforeach;
            if (self::destroyQtdeAvaria($produtoID, $qtdeAvaria, $user) == 1):
                $deleteAvaria = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_avaria WHERE id_avaria='$idAvaria'");
                $deleteAvaria->execute();
            else:
                $erroLocalDelete = 1;
            endif;
            return $erroLocalDelete;

        } catch (PDOException $erroExp) {
        }
    }

    /**
     * Método ele retorna null caso aconteça algum erro, caso contrário ele retorna um int
     * @param $produto integer
     * @param $quantidade integer
     * @param $user string
     *
     * @return int|null
     */
    public function destroyQtdeAvaria($produto, $quantidade, $user)
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
                    'user' => $user
                );
                $this->estoqueClass->transacaoRegistro($arrayTempTransacao);
                $status = 1;
            }
            return $status;
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            return null;
        }
    }
}