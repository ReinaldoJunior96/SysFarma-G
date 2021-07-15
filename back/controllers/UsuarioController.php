<?php
require_once('conexao.php');
require_once('EstoqueController.php');

class UsuarioController
{
    public $conn = null;

    function __construct()
    {
        $this->conn = PDOconectar::conectar();
    }

    public function login($user, $password): int
    {
        $user = $this->conn->prepare("SELECT * FROM tbl_usuarios WHERE nome_user='$user' and password='$password'");
        $user->execute();
        return $user->rowCount();
    }
    
    public function verificarPermissao($user){
        $user = $this->conn->prepare("SELECT * FROM tbl_usuarios WHERE nome_user='$user'");
        $user->execute();
        return $user->fetchAll(PDO::FETCH_OBJ);
    }
}