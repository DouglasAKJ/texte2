<?php 
require_once "../src/database/Database.php";
require_once "../model/Produto.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];

        $produto = new Produto($nome, $preco, $quantidade);

        $sql = "INSERT INTO produtos(nome, preco, quantidade) VALUES(?, ?, ?)";

        $db = new Database();

        $db->insert($sql, [$nome, $preco, $quantidade]);

        header("Location: ../pages/admin.php");
    }

?>