<?php
require_once('conexao.php');

class SetorController
{
    public $conn = null;

    function __construct()
    {
        $this->conn = PDOconectar::conectar();
    }

    public function listSetores(): array
    {
        $indexSetores = null;

        try {
            $querySelect = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_setores ORDER BY setor_s ASC");
            $querySelect->execute();
            $indexSetores = $querySelect->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
        return $indexSetores;
    }

    public function storeSetor($setor)
    {
        try {
            $updateNameSetor = str_replace(" ", "-", $setor);
            $this->conn->beginTransaction();
            $insertSetorQuery = /** @lang text */
                "INSERT INTO tbl_setores(setor_s) VALUES (:setor_s)";
            $sqlExecute = $this->conn->prepare($insertSetorQuery);
            $sqlExecute->bindValue(':setor_s', $updateNameSetor);
            $sqlExecute->execute();
            $this->conn->commit();
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }

    public function deleteSetor($id): int
    {
        $erroAux = 0;
        try {
            $this->conn->beginTransaction();

            $deleteSetorQuery = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_setores WHERE id_setor=$id");
            $deleteSetorQuery->execute();

            $this->conn->commit();

            $erroAux = ($this->conn->commit()) ? 0 : 1;

        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
        return $erroAux;
    }
}