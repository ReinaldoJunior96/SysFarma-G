<?php 
$arquivo = $_GET['exame_string']; // Nome do Arquivo
$local = '../../../../dist/examespdf/anatomo/'; // Pasta que contém os arquivos para download
$local_arquivo = $local.$arquivo; // Concatena o diretório com o nome do arquivo

header('Cache-control: private');
header('Content-Type: application/octet-stream');
header('Content-Length: '.filesize($local_arquivo));
header('Content-Disposition: filename='.$arquivo);
header("Content-Disposition: attachment; filename=".basename($local_arquivo));
readfile($local_arquivo);


