<?php
session_start();
unset($_SESSION['user'] );
unset($_SESSION['password'] );
session_destroy();
header("location: ../../../views/user/login.php");