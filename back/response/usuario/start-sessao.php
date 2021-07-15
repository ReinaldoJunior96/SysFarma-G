<?php
include '../../controllers/UsuarioController.php';
$attLogin = new UsuarioController();
if($attLogin->login($_POST['usuario'],$_POST['password']) == 1){
    session_cache_expire(1440);
    session_start();
    $_SESSION['usuario'] = (!isset($_POST['usuario'])) ? NULL : $_POST['usuario'];
    $_SESSION['password'] = (!isset($_POST['password'])) ? NULL : $_POST['password'];
    if($_SESSION['usuario'] == 'exames'){
        header("location: ../../../views/exame/usuario/dashboard.php");
    }else{
        header("location: ../../../views/usuario/dashboard.php");
    }
    
}else{
    header("location: ../../../views/usuario/login.php");
}





