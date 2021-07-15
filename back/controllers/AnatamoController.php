<?php
require_once 'conexao.php';
date_default_timezone_set('America/Sao_Paulo');

class AnatomoController
{
    public $conn = null;
    public $data = null;
    public function __construct()
    {
        $this->conn = PDOconectar::conectar();
        $this->data = new DateTime('NOW');
    }

    public function cadastroExame($dados, $file)
    {
        $date = date_create($dados['data_amostra']);
        try {
            $this->conn->beginTransaction();
            $cadastroQuery = /** @lang text * */
            "INSERT INTO tbl_anatomopatologia(cod_anatomo,nome_animal,nome_proprietario,raca_anatomo,data_amostra,exame_string)
                VALUES (:cod_anatomo,:nome_animal,:nome_proprietario,:raca_anatomo,:data_amostra,:exame_string)";
            $sql = $this->conn->prepare($cadastroQuery);
            $sql->bindValue(':cod_anatomo', $dados['cod_anatomo']);
            $sql->bindValue(':nome_animal', $dados['n_animal']);
            $sql->bindValue(':nome_proprietario', $dados['n_proprietario']);
            $sql->bindValue(':raca_anatomo', $dados['raca']);
            $sql->bindValue(':data_amostra', date_format($date, 'Y-m-d H:i:s'));
            $sql->bindValue(':exame_string', $file['name']);
            $sql->execute();
            if ($sql) {
                self::uploadFileAnatomo($file);
                $this->conn->commit();
            }
        } catch (PDOException $erro) {
            $this->conn->rollBack();
        }
    }
    public function uploadFileAnatomo($file)
    {
        if (isset($file)) {
            $diretorio = "../../../../dist/examespdf/anatomo/"; //define o diretorio para onde enviaremos o arquivo
            move_uploaded_file($file['tmp_name'], $diretorio . $file['name']); //efetua o upload
        }
    }

    public function listExamesAnatomo()
    {
        $querySelect = $this->conn->prepare(/** @lang text */"SELECT * FROM tbl_anatomopatologia");
        $querySelect->execute();
        return $querySelect->fetchAll(PDO::FETCH_OBJ);
    }

}
