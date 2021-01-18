<?php
require_once('conexao.php');

class SetorController{
    /**
     * @var PDO
     */
    public $conn = null;

    function __construct()
    {
        $this->conn = PDOconectar::conectar();
    }
    public function verSetores()
    {
        try {
            $view_setores = $this->conn->prepare(/** @lang text */ "SELECT * FROM tbl_setores ORDER BY setor_s ASC");
            $view_setores->execute();
            return $view_setores->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $erro) {
            echo "<script language=\"javascript\">alert(\"Erro...\")</script>";
        }
    }
}