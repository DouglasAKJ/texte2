<?php

require_once "../src/database/Database.php";
require_once "../model/Produto.php";

session_start();

$idProduto = $_POST['adicionar'];
$quantidades = $_POST['quantidade'];

// Inicia o carrinho, se ainda não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$db = new Database();
$sql = "SELECT * FROM produtos";
$produtos = $db->select($sql);

foreach ($produtos as $produto) {
    if ($produto->id == $idProduto) {
        $quantidade = isset($quantidades[$produto->id]) ? (int)$quantidades[$produto->id] : 1;

        // Cria objeto Produto com a quantidade desejada
        $produtoRecebido = new Produto($produto->nome, $produto->preco, $quantidade);

        // Verifica se já está no carrinho
        $encontrado = false;
        foreach ($_SESSION['carrinho'] as &$item) {
            if ($item->getNome() === $produtoRecebido->getNome()) {
                $novaQtd = $item->getQuantidade() + $quantidade;
                $item->setQuantidade($novaQtd);
                $encontrado = true;
                break;
            }
        }

        // Se não estava no carrinho, adiciona novo
        if (!$encontrado) {
            $_SESSION['carrinho'][] = $produtoRecebido;
        }

        break; // <- aqui o break está no lugar certo
    }
}

header('Location: ../pages/menu.php');
exit;
