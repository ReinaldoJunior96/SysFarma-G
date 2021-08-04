<?php
session_start();
unset($_SESSION['usuario'] );
unset($_SESSION['password'] );
session_destroy();
header("location: ../../../views/usuario/login.php");