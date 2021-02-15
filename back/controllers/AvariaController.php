<?php
require_once('EstoqueController.php');
require_once('conexao.php');
date_default_timezone_set('America/Sao_Paulo');

class AvariaController
{
    public $conn = null;

    function __construct()
    {
        $this->conn = PDOconectar::conectar();
    }

    public function novoProdudoAvariado($produto)
    {
        $data = new DateTime('NOW');
        try {
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
            $sql->bindValue(':data_cadastro', date_format($data, 'Y-m-d H:i:s'));
            $sql->execute();
            if ($sql) {
                $this->conn->commit();
                self::removerQuantidadeAvaria($produto['produtoavaria'], $produto['quantidadeavaria'], $produto['user']);
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro ao cadastrar produto\")</script>";
        }
    }

    public function removerQuantidadeAvaria($produto, $quantidade, $user)
    {
        try {
            $estoqueClass = new EstoqueController();
            if ($estoqueClass->verificarQuantidade($produto, $quantidade, 0) == 1):
                header("location: ../../views/saida/saida-almoxarifado.php?qtderro=fail");
            else:
                $emEstoque = $estoqueClass->verificarQuantidade($produto, $quantidade, 1);
                $this->conn->beginTransaction();
                $alteraQuantidadeSQL = /** @lang text * */
                    "UPDATE tbl_estoque SET quantidade_e=:quantidade WHERE id_estoque='$produto'";
                $fazer_alteracao = $this->conn->prepare($alteraQuantidadeSQL);
                $fazer_alteracao->bindValue(':quantidade', $emEstoque - $quantidade);
                $fazer_alteracao->execute();
                if ($fazer_alteracao) {
                    $this->conn->commit();
                    $data = new DateTime('NOW');
                    /* transacao */
                    $arrayTempTransacao = array(
                        'produto' => $produto,
                        'data' => date_format($data, 'Y-m-d H:i:s'),
                        'tipo' => 'Avaria/Vencido',
                        'estoqueini' => $emEstoque,
                        'quantidade' => $quantidade,
                        'estoquefi' => $emEstoque - $quantidade,
                        'cancelada' => ' ',
                        'user' => $user
                    );

                    $transacao = new EstoqueController();
                    $transacao->transacaoRegistro($arrayTempTransacao);
                }
            endif;
        } catch
        (PDOException $erro) {
            $this->conn->rollBack();
        }
    }

    public function buscarProdutoAvariados()
    {
        $querySelect = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_avaria 
        INNER JOIN tbl_estoque 
        ON tbl_avaria.produto_avaria = tbl_estoque.id_estoque");
        $querySelect->execute();
        return $querySelect->fetchAll(PDO::FETCH_OBJ);
    }

    public function buscarAvariasID($idAvaria)
    {
        $querySelect = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_avaria WHERE id_avaria='$idAvaria'");
        $querySelect->execute();
        return $querySelect->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteProdutoAvaria($idAvaria, $user)
    {
        $produto = 0;
        $quantidadeAvaria = 0;
        try {
            $avaria = self::buscarAvariasID($idAvaria);
            foreach ($avaria as $k):
                $produto = $k->produto_avaria;
                $quantidadeAvaria = $k->quantidade_avaria;
            endforeach;
            self::adiconarQuantidadeAvaria($produto, $quantidadeAvaria, $user);
            $deleteAvaria = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_avaria WHERE id_avaria='$idAvaria'");
            $deleteAvaria->execute();
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro ao excluir produto!!\")</script>";
        }
    }

    public function adiconarQuantidadeAvaria($produto, $quantidade, $user)
    {
        $inEstqoue = 0;
        $status = "";
        try {
            $estoqueClass = new EstoqueController();
            $produtoEstoque = $estoqueClass->estoqueID($produto);
            foreach ($produtoEstoque as $v):
                $inEstqoue = $v->quantidade_e;
            endforeach;
            $this->conn->beginTransaction();
            $alteraQuantidadeSQL = /** @lang text * */
                "UPDATE tbl_estoque SET quantidade_e=:quantidade WHERE id_estoque='$produto'";
            $realizarAlteracao = $this->conn->prepare($alteraQuantidadeSQL);
            $realizarAlteracao->bindValue(':quantidade', $inEstqoue + $quantidade);
            $realizarAlteracao->execute();
            if ($realizarAlteracao) {
                $this->conn->commit();
                $data = new DateTime('NOW');
                /* transacao */
                $arrayTempTransacao = array(
                    'produto' => $produto,
                    'data' => date_format($data, 'Y-m-d H:i:s'),
                    'tipo' => 'Avaria/Vencido',
                    'estoqueini' => $inEstqoue,
                    'quantidade' => $quantidade,
                    'estoquefi' => $inEstqoue + $quantidade,
                    'cancelada' => 'Sim',
                    'user' => $user
                );
                $transacao = new EstoqueController();
                $transacao->transacaoRegistro($arrayTempTransacao);
            }
            return $status = 'success';

        } catch
        (PDOException $erro) {
            $this->conn->rollBack();
            return $status = 'fail';
        }
    }
}