<?php

require_once('CLASSES/usuarios.php');
$usuario = new Usuarios()

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
        <h1>Cadastre-se</h1>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome Completo" maxlength="30">
            <input type="text" name="telefone" placeholder="Telefone" maxlength="30">
            <input type="email" name="email" placeholder="Email" maxlength="40">
            <input type="password" name="senha" placeholder="Senha" maxlength="15">
            <input type="password" name="confSenha" placeholder="Confirmar Senha" maxlength="15">
            <input type="submit" value="CADASTRAR">
            <a href="index.php"><strong>Acesse!</strong></a>
        </form>
    </div>
    <?php
    //Verificar se clicou no botão enviando os dados via POST
    if(isset($_POST["nome"])) 
    {

    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    $confirmarSenha = addslashes($_POST['confSenha']);
    

    //Verifica se está tudo preenchido
    if(!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confirmarSenha)) {

        $usuario->conexao("login", "localhost", "root", "");
        if($usuario->msgErro == "") {

            if($senha == $confirmarSenha) {

                if($usuario->cadastrar($nome, $telefone, $email, $senha)) {
                    ?>
                    <div id="msg-sucesso">
                    Cadastrado com sucesso! Acesse para entrar!
                    </div>
                    <?php

                } else {
                    
                    ?>
                    <div class="msg-erro">
                    Email já cadastrado!
                    </div>
                    <?php
                }

            } else {
                ?>
                <div class="msg-erro">
                Senha e confirmar senha não correspondem
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

        echo "Preencha todos os campos";

    }
    }


?>
    
</body>
</html>