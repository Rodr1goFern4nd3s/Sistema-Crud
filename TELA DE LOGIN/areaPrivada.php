<?php

session_start();
if(!isset($_SESSION['id_usuario'])) {//verifica se a pessoa está logada

    header("location: index.php"); //senao é redirecionada para a area de login
    exit;
}

?>
<p>Seja bem Vindo</p>
<a href="sair.php">SAIR</a>