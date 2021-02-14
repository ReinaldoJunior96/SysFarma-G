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
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro ao cadastrar produto\")</script>";
        }
    }

    public function removerQuantidadeAvaria($produto, $quantidade)
    {
        try {
            $estoqueClass = new EstoqueController();
            if ($estoqueClass->verificarQuantidade($produto, $quantidade, 0) == 1):
                header("location: ../../views/saida/saida-almoxarifado.php?qtderro=fail");
            else:
                $emEstoque = $estoqueClass->verificarQuantidade($produto, $quantidade, 0);
                $this->conn->beginTransaction();
                $alteraQuantidadeSQL = /** @lang text **/
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
                        'tipo' => 'Avaria',
                        'estoqueini' => $emEstoque,
                        'quantidade' => $quantidade,
                        'estoquefi' => $emEstoque - $quantidade,
                        'cancelada' => ' ',
                        'user' => $saida['user']
                    );
                    $transacao = new EstoqueController();
                    $transacao->transacaoRegistro($arrayTempTransacao);
                }
            endif;
        } catch
        (PDOException $erro) {
            $this->conn->rollBack();
            $status = "fail";
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
}