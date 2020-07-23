<?php

require_once("CLASSES/usuarios.php");
$usuario = new Usuarios();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/estilo.css">
    <title>Projeto Login</title>
</head>
<body>

    <div id="corpo-form">
        <h1>Entrar</h1>
        <form method="POST">
            <input type="email" placeholder="Email" name="email">
            <input type="password" placeholder="Senha" name="senha">
            <input type="submit" value="ACESSAR">
            <a href="cadastrar.php">Ainda não é inscrito? <strong>Cadastre-se</strong></a>
        </form>
    </div>
    <?php
    if(isset($_POST["email"])) 
    {

        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        //Verifica se está tudo preenchido
        if(!empty($email) && !empty($senha)) {

            $usuario->conexao("login", "localhost", "root", "");

            if($usuario->msgErro == "") {

                if($usuario->logar($email, $senha)) {

                    header("location: areaPrivada.php");

                } else {
                    ?>
                    <div class="msg-erro">
                        Email e/ou senha estão incorretos!
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="msg-erro">
                    <?php echo "Erro: " . $usuario->msgErro; ?>
                </div>
                <?php
            }

        } else {
            ?>
            <div class="msg-erro">
            Preencha todos os campos!
            </div>
            <?php
        }
    }
    ?>
</body>
</html>