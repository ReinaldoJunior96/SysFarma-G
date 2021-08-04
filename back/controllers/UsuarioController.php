<?php
require_once 'conexao.php';

class UsuarioController
{
    public $conn = null;

    public function __construct()
    {
        $this->conn = PDOconectar::conectar();
    }

    /*Retorna 1 se encontrar um usuário e retorna 0 se não encontrar nada*/
    public function login($user, $password): int
    {
        $user = $this->conn->prepare("SELECT * FROM tbl_usuarios WHERE nome_user='$user' and password='$password'");
        $user->execute();
        return $user->rowCount();
    }
}
