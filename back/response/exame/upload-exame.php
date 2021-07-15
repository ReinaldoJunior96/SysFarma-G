<?php
$msg = false;



function uploadFilePatologia($file)
{
    if (isset($_FILES['arquivo'])) {
        $extensao = strtolower(substr($_FILES['arquivo']['name'], -4)); //pega a extensao do arquivo
        $novo_nome = mt_rand(1, 9999) . $extensao; //define o nome do arquivo . $extensao
        $diretorio = "../../dist/examespdf/patologia/"; //define o diretorio para onde enviaremos o arquivo
        move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio . $novo_nome); //efetua o upload
        //$new_doc = new ClienteDAO();
        //var_dump($_POST['id']);
        //$new_doc->addDocuments($_POST['titulo_doc'], $novo_nome, $_POST['id']);
    }
}

