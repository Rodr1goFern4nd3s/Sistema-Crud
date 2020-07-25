<?php
session_start();

if(!isset($_SESSION['id_usuario'])) {//verifica se a pessoa está logada

    header("location: index.php"); //senao é redirecionada para a area de login
    exit;
}

require_once("CLASSES/Produtos.php");
$p = new Produto("login","localhost", "root", "");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/areaPrivadaEstilo.css">
</head>
<body>

    <?php

    if(isset($_POST['nome'])){//Este if verifica se a pessoa clicou em cadastrar

        $nome = addslashes($_POST['nome']); //addslashes - esta função faz a proteção para que não permita vir códigos maliciosos
        $preco = addslashes($_POST['preco']);
        $categoria = addslashes($_POST['categoria']);

        if(!empty($nome) && !empty($preco) && !empty($categoria)) { //Este if verifica se o usuário preencheu todos os campos

            if(!$p->cadastrarProduto($nome, $preco, $categoria)){
                
                echo "Produto já cadastrado";

            }

        } else {

            echo "Preencha todos os campos";

        }
    } 

    ?>

    <section id="esquerda">
        <form method="POST">
            <h2>Cadastrar Produto</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome">
            <label for="preco">Preço</label>
            <input type="float" name="preco" id="preco">
            <label for="categoria">Categoria</label>
            <input type="text" name="categoria" id="categoria">
            <input type="submit" value="Cadastrar">
            <br>
            <a href="sair.php">SAIR</a>
        </form>
    </section>
    <section id="direita">
    <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>PREÇO</td>
                <td colspan="2">CATEGORIA</td>
            </tr>
        <?php 
        
        $dados = $p->buscarDados();
        if(count($dados) > 0) { //Tem produtos cadastrados no banco

            for ($i=0; $i < count($dados); $i++) {
                echo "<tr>";
                foreach($dados[$i] as $k => $v) {

                    if($k != "id_produto") {

                        echo "<td>".$v."</td>";

                    }
                }
                ?>
                    <td>
                        <a href="#">Editar</a>
                        <a href="areaPrivada.php?id=<?php echo $dados[$i]['id_produto'];?>">Excluir</a>
                    </td>
                <?php
                echo "</tr>";
            }
        }  else { //O banco de dados está vazio

            echo "Ainda não ha produtos cadastrados";

        }   
        ?>

        </table> 
    
    </section>    
</body>
</html>

<?php 

if(isset($_GET['id'])) {

    $id_produto = addslashes($_GET['id']);
    $p->excluirProduto($id_produto);
    header("location: areaPrivada.php");
}

?>