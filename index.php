<?php
session_start();
if ($_SESSION['usuario'] == NULL || $_SESSION['password'] == NULL) {
    header("location: views/usuario/login.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="refresh" content="0; URL=views/usuario/dashboard.php"/>
</head>

<body>
</body>

</html>