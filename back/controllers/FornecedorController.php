<?php
require_once('conexao.php');

class FornecedorController
{
    public $conn = null;

    function __construct()
    {
        $this->conn = PDOconectar::conectar();
    }

    public function storeFornecedor($fornecedor)
    {
        try {
            $this->conn->beginTransaction();

            $insertFonecedorQuery = /** @lang text */
                "INSERT INTO tbl_fornecedores(nome_fornecedor,contato_fornecedor,email_fornecedor,endereco_f,cnpj_f) 
			VALUES (:nome_fornecedor,:contato_fornecedor,:email_fornecedor,:endereco_f,:cnpj_f)";

            $sqlExecute = $this->conn->prepare($insertFonecedorQuery);

            self::dadosFornecedor($sqlExecute, $fornecedor);

            $this->conn->commit();

        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }

    public function updateFornecedor($fornecedor, $id)
    {
        try {
            $this->conn->beginTransaction();

            $query_update = /** @lang text */
                "UPDATE tbl_fornecedores SET 
			nome_fornecedor=:nome_fornecedor,
			contato_fornecedor=:contato_fornecedor,
			email_fornecedor=:email_fornecedor,
			endereco_f=:endereco_f,
			cnpj_f=:cnpj_f
			WHERE id_fornecedor='$id'";

            $sqlExecute = $this->conn->prepare($query_update);

            self::dadosFornecedor($sqlExecute, $fornecedor);

            $this->conn->commit();

        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }

    public function deleteFornecedor($id): int
    {
        $auxErro = 0;
        try {
            $this->conn->beginTransaction();

            $deleteFornecedor = $this->conn->prepare(/** @lang text */
                "DELETE FROM tbl_fornecedores WHERE id_fornecedor='$id'");
            $deleteFornecedor->execute();

            $this->conn->commit();

        } catch (PDOException $erro) {

            $this->conn->rollBack();
            $auxErro = 1;
        }
        return $auxErro;
    }

    public function dadosFornecedor($sqlExecute, $fornecedor)
    {
        $sqlExecute->bindValue(':nome_fornecedor', $fornecedor['nome']);
        $sqlExecute->bindValue(':contato_fornecedor', $fornecedor['contato']);
        $sqlExecute->bindValue(':email_fornecedor', $fornecedor['email']);
        $sqlExecute->bindValue(':endereco_f', $fornecedor['endereco']);
        $sqlExecute->bindValue(':cnpj_f', $fornecedor['cnpj']);
        $sqlExecute->execute();
    }


    public function listFornecedores(): array
    {
        $fornecedores = null;
        try {
            $viewFornecedores = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_fornecedores ORDER BY nome_fornecedor ASC");
            $viewFornecedores->execute();
            $fornecedores = $viewFornecedores->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
        }
        return $fornecedores;
    }

    public function listUniqueFornecedor($id): array
    {
        $uniqueFornecedor = null;
        try {
            $viewFornecedor = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_fornecedores WHERE id_fornecedor='$id'");
            $viewFornecedor->execute();
            $uniqueFornecedor = $viewFornecedor->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
        }
        return $uniqueFornecedor;
    }

    public function listProdFornecedores($fornecedor): array
    {
        $prodFornecedores = null;
        try {
            $viewFornecedor = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_prod_fornecedor 
            INNER JOIN tbl_estoque ON tbl_prod_fornecedor.idproduto = tbl_estoque.id_estoque
            WHERE tbl_prod_fornecedor.idfornecedor='$fornecedor'");
            $viewFornecedor->execute();
            $prodFornecedores = $viewFornecedor->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
        }
        return $prodFornecedores;
    }

}