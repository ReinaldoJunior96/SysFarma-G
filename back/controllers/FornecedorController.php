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
            $query = /** @lang text */
                "INSERT INTO tbl_fornecedores(nome_fornecedor,contato_fornecedor,email_fornecedor,endereco_f,cnpj_f) 
			VALUES (:nome_fornecedor,:contato_fornecedor,:email_fornecedor,:endereco_f,:cnpj_f)";
            $sql = $this->conn->prepare($query);
            $sql->bindValue(':nome_fornecedor', $fornecedor['nome']);
            $sql->bindValue(':contato_fornecedor', $fornecedor['contato']);
            $sql->bindValue(':email_fornecedor', $fornecedor['email']);
            $sql->bindValue(':endereco_f', $fornecedor['endereco']);
            $sql->bindValue(':cnpj_f', $fornecedor['cnpj']);
            $sql->execute();
            if ($sql) {
                $this->conn->commit();
            }
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
            $editFornecedor = $this->conn->prepare($query_update);
            $editFornecedor->bindValue(':nome_fornecedor', $fornecedor['nome']);
            $editFornecedor->bindValue(':contato_fornecedor', $fornecedor['contato']);
            $editFornecedor->bindValue(':email_fornecedor', $fornecedor['email']);
            $editFornecedor->bindValue(':endereco_f', $fornecedor['endereco']);
            $editFornecedor->bindValue(':cnpj_f', $fornecedor['cnpj']);
            $editFornecedor->execute();
            if ($editFornecedor) {
                $this->conn->commit();
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
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

    public function deleteFornecedor($id)
    {
        try {
            $deleteFornecedor = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_fornecedores WHERE id_fornecedor='$id'");
            $deleteFornecedor->execute();
        } catch (PDOException $erro) {
        }
    }

}