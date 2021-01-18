<?php
include_once '../../controllers/configCRUD.php';
include_once('../../controllers/EstoqueController.php');
date_default_timezone_set('America/Sao_Paulo');


$new_saida = new EstoqueController();
$horarioEntrada = new DateTime('NOW');


$saida = array(
    'produto' => $_POST['produto_s'],
    'quantidade' => $_POST['saidaqte_p'],
    'setor' => $_POST['setor_s'],
    'data' => $_POST['data_s'],
    'user' => $_POST['user'],
);

for ($i = 0; $i < count($saida['produto']); $i++):
    if (!empty($saida['produto'][$i]) and !empty($saida['quantidade'][$i])):
        $vrrSaida = array(
            'produto' => $saida['produto'][$i],
            'quantidade' => $saida['quantidade'][$i],
            'setor' => $_POST['setor_s'],
            'data' => date('Y-m-d', strtotime($_POST['data_s'])) . " " . $horarioEntrada->format('H:i:s'),
            'user' => $_POST['user'],
        );
        $new_saida->registrarSaida($vrrSaida);
    endif;
endfor;



echo "<script language=\"javascript\">window.history.go(-2);</script>";

?>