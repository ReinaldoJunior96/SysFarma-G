<?php
include '../../controllers/UsuarioController.php';
$attLogin = new UsuarioController();
if($attLogin->login($_POST['user'],$_POST['password']) == 1){
    session_cache_expire(1440);
    session_start();
    $_SESSION['user'] = (!isset($_POST['user'])) ? NULL : $_POST['user'];
    $_SESSION['password'] = (!isset($_POST['password'])) ? NULL : $_POST['password'];
    header("location: ../../../views/user/dashboard.php");
}else{
    header("location: ../../../views/user/login.php");
}





