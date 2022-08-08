<?php

session_start();
unset($_SESSION["usuario"]);
unset($_SESSION['e-mail']);
unset($_SESSION["logado"]);
header('location:index.php');
?>
