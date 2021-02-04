<?php
require_once('../../controllers/EstoqueController.php');
date_default_timezone_set('America/Sao_Paulo');
$novaSaida = new EstoqueController();

/* Pegos o resto da hora exata da saída dos produtos*/
$horarioEntrada = new DateTime('NOW');

/* Recebe os todos os produtos*/
$produtosGerais = array(
    'produto' => $_POST['produto_s'],
    'quantidade' => $_POST['saidaqte_p'],
    'setor' => $_POST['setor_s'],
    'data' => $_POST['data_s'],
    'user' => $_POST['user'],
);
/* Recebe os produtos filtrados */
$produtoFiltrado = array(
    'produto' => array(),
    'quantidade' => array(),
    'setor' => $_POST['setor_s'],
    'data' => date('Y-m-d', strtotime($_POST['data_s'])) . " " . $horarioEntrada->format('H:i:s'),
    'user' => $_POST['user'],
);
/* Recebe os produtos inválidos */
$produtoInvalidos = array();

/* Percorre para tirar os produtos que estão com quantidade vazias */
for ($i = 0; $i < count($produtosGerais['produto']); $i++):
    if (!empty($produtosGerais['produto'][$i]) and !empty($produtosGerais['quantidade'][$i])):
        array_push($produtoFiltrado['produto'], $produtosGerais['produto'][$i]);
        array_push($produtoFiltrado['quantidade'], $produtosGerais['quantidade'][$i]);
    endif;
endfor;
$produtosErro = $novaSaida->registrarSaida($produtoFiltrado);
$erro = array();
foreach ($produtosErro as $prod){
    $produtoTotal = $novaSaida->estoqueID($prod);
    foreach ($produtoTotal as $i){
        array_push($erro ,$i->produto_e);
    }
}
if(count($erro) == 0){
    header("location: ../../../views/saida/iniciar.php?produtos=success");
}else{
    $query = http_build_query(array('erroprod' => $erro));
    header("location: ../../../views/saida/iniciar.php?". $query);
}



