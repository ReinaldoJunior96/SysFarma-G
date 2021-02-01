<?php
require_once('../../controllers/EstoqueController.php');
$devolucao = new EstoqueController();
$devolucao->registrarDevolucao($_POST);


?>