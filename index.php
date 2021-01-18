<?php
session_start();
if ($_SESSION['user'] == NULL || $_SESSION['password'] == NULL) {
    header("location: views/user/login.php");
}
require_once('back/controllers/configCRUD.php');
$s = new ConfigCRUD();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="refresh" content="0; URL=views/user/dashboard.php"/>
</head>

<body>
</body>

</html>