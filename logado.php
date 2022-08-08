<?php
session_start();
if (isset($_SESSION['logado'])) {
    if ($_SESSION['logado'] != 'sim') {
        $_SESSION['erro'] = 1;
        header("Location:index.php");
    }
} else {
    $_SESSION['erro'] = 1;
    header("Location:index.php");
}
?>