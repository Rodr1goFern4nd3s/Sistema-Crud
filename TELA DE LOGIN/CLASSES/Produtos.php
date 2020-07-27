<?php

class Produto {

    private $pdo;

    public function __construct($dbname, $host, $user, $password) {

        try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$password);
        } catch (PDOException $e) {
            echo "Erro com o banco de dados: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erro genérico: " . $e->getMessage();
        }
    }

    //Este método busca os dados do banco e coloca na tela da direita
    public function buscarDados() {

        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM produtos ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    //Método para cadastrar um produto no banco de dados
    public function cadastrarProduto($nome, $preco, $categoria) {
        //Primeiro verificar se já existe cadastro

        $cmd = $this->pdo->prepare("SELECT id FROM produtos WHERE nome = :nome");
        $cmd->bindValue(":nome", $nome);
        $cmd->execute();

        if($cmd->rowCount() > 0) { //Se vir maior que zero ja existe no banco
            return false;
        
        } else {

            $cmd = $this->pdo->prepare("INSERT INTO produtos (nome, preco, categoria) VALUES (:nome, :preco, :categoria)");
            $cmd->bindValue(":nome", $nome);
            $cmd->bindValue(":preco", $preco);
            $cmd->bindValue(":categoria", $categoria);
            $cmd->execute();
            return true;

        }
    }

    public function excluirProduto($id) {

        $cmd = $this->pdo->prepare("DELETE FROM produtos WHERE id_produto = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    //Método para editar levando os dados para a tela da esquerda
    public function buscarProdutos($id) {

        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM produtos WHERE id_produto = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function atualizarDados($id, $nome, $preco, $categoria) {

        $cmd = $this->pdo->prepare("UPDATE produtos SET nome = :nome, preco = :preco, categoria = :categoria WHERE id_produto = :id");
        $cmd->bindValue(":id", $id);
        $cmd->bindValue(":nome", $nome);
        $cmd->bindValue(":preco", $preco);
        $cmd->bindValue(":categoria", $categoria);
        $cmd->execute();

    }

}

?>