<?php
include '../upload-exame.php';
include '../../../controllers/AnatamoController.php';

$anatamo = new AnatomoController();
echo "<pre>";
for ($i = 0; $i < count($_FILES['examepdf']['name']); $i++) {
    $basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $extensao = strtolower(substr($_FILES['examepdf']['name'][$i], -4));
    $novoNome = str_shuffle($basic) . $extensao;
    $_FILES['examepdf']['name'][$i] = $novoNome;
    $file = array(
        'name' =>       $_FILES['examepdf']['name'][$i],
        'type' =>       $_FILES['examepdf']['type'][$i],
        'tmp_name' =>   $_FILES['examepdf']['tmp_name'][$i],
        'error' =>      $_FILES['examepdf']['error'][$i],
        'size' =>       $_FILES['examepdf']['size'][$i]
    );        
    $anatamo->cadastroExame($_POST, $file);
}
echo "</pre>";
