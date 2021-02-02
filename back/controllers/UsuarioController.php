<?php
require_once('conexao.php');
require_once ('EstoqueController.php');

class UsuarioController
{
    public $conn = null;

    function __construct()
    {
        $this->conn = PDOconectar::conectar();
    }
    public function login($user, $password)
    {
        $user = $this->conn->prepare("SELECT * FROM tbl_usuarios WHERE nome_user='compras.hvu' and password='$password'");
        $user->execute();
        return $user->rowCount();
    }



}