<?php

/**
 *
 */
class PDOconectar
{

    function __construct()
    {
    }

    public static function conectar(): PDO
    {
        $conexaoPDO = null;
        try {
            $conexaoPDO = new PDO("mysql:host=localhost;dbname=boxhub;charset=utf8", "root", "",
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            //return new PDO("mysql:host=mysql.uemapet.com;dbname=uemapet;charset=utf8", "uemapet", "Reinaldo@123",
            //array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
        return $conexaoPDO;
    }
}
