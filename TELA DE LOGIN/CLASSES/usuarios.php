<?php

class Usuarios {

    private $pdo;
    public $msgErro = ""; //tudo Ok

    public function conexao($nome, $host, $usuario, $senha) {

        global $pdo;
        try {
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
        } catch(PDOException $e) {
            $msgErro = $e->getMessage();
        }
    }

    public function cadastrar($nome, $telefone, $email, $senha) {

        global $pdo;
        //verificar se ja existe o email cadastrado
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();
        
        if($sql->rowCount() > 0) {

            return false; //Já é cadastrado
        
        } else {
            //Caso não, Cadastre

            $sql = $pdo->prepare("INSERT INTO usuarios(nome, telefone, email, senha) VALUES (:nome, :telefone, :email, :senha)");

            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":telefone", $telefone);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":senha", md5($senha));

            $sql->execute();
            return true;
        }
    }

    public function logar($email, $senha) {

        global $pdo;
        //Verificar se o email e senha estão cadastrados
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :email AND senha = :senha");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", md5($senha));
        $sql->execute();

        if($sql->rowCount() > 0) {
            //se sim, entrar no sistema (sessao)
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true; //Logado com sucesso

        } else {

            return false; // Não foi possível logar
        }
        
    }
}

?>