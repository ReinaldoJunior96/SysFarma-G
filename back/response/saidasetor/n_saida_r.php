<?php
require_once('../../controllers/EstoqueController.php');
date_default_timezone_set('America/Sao_Paulo');
/* ================ Váriaveis de Iníncio ================= */
$estoqueClass = null;
$data = null;
/* ================  */

/* Importa classe Estoque */
$estoqueClass = new EstoqueController();

/* Pega a hora exata da saída dos produtos*/
$data = new DateTime('NOW');

/* Recebe os todos os produtos e as quantidades*/
$produtosGerais = array(
    'produto' => $_POST['produto_s'],
    'quantidade' => $_POST['saidaqte_p'],
);

var_dump($produtosGerais);

/* Array que vai recerber apenas os produtos com quantidade diferente de vazio */
$produtoFiltrado = array(
    'produto' => array(),
    'quantidade' => array(),
    'setor' => $_POST['setor_s'],
    'data' => (empty($_POST['data_s'])) ? date_format($data, 'Y-m-d H:i:s') : date('Y-m-d', strtotime($_POST['data_s'])) . " " . $data->format('H:i:s'),
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
/*
 * Manda para o back os produtos filtrados no ponto de inserir no banco
 * Retorna os produtos [id] que não foram registrados
 */
$produtosErro = $estoqueClass->registrarSaida($produtoFiltrado);

/*
 * Array que armazena os produtos que tiveram
 * provavelmente a quantidade solicitada maior que do estoque
 */
$erro = array();

/*
 * Pega o nome dos produtos para retorno para o front
 */
foreach ($produtosErro as $prod) {
    $produtoTotal = $estoqueClass->estoqueID($prod);
    foreach ($produtoTotal as $i) {
        array_push($erro, $i->produto_e);
    }
}

/*
 * Se não tiver erros ele retorna o success, caso contrário retorno os erros
 */

if (count($erro) == 0) {
    //header("location: ../../../views/saida/iniciar.php?produtos=success");
} else {
    //$query = http_build_query(array('erroprod' => $erro));
    //header("location: ../../../views/saida/iniciar.php?" . $query);
}



