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
        $setor_replace = str_replace(" ", "-", $setor);
        try {
            $this->conn->beginTransaction();
            $query_Sql = /** @lang text */
                "INSERT INTO tbl_setores(setor_s) VALUES (:setor_s)";
            $sql = $this->conn->prepare($query_Sql);
            $sql->bindValue(':setor_s', $setor_replace);
            $sql->execute();
            if ($sql) {
                $this->conn->commit();
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }

    public function deleteSetor($id)
    {
        try {
            $query_Sql = $this->conn->prepare(/** @lang text */ "DELETE FROM tbl_setores WHERE id_setor=$id");
            $query_Sql->execute();
            if ($query_Sql) {
                $this->conn->commit();
            }
        } catch (PDOException $erro) {
        }
    }
}