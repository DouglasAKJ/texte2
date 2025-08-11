<?php
require_once "../src/database/Database.php";
require_once "../model/Produto.php";
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuarioSessao = $_SESSION['usuario'];
$usuarioId = $usuarioSessao['id'];

$db = new Database();

// Buscar dados completos do usuário, incluindo endereço
$usuario = $db->select("SELECT * FROM usuarios WHERE id = $usuarioId");
$usuarioObj = isset($usuario[0]) ? $usuario[0] : null;

// Buscar pedidos do usuário
$pedidos = $db->select("SELECT * FROM pedidos WHERE usuario_id = $usuarioId ORDER BY data DESC");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Status dos Pedidos</title>
    <link rel="stylesheet" href="../assets/estilo-status.css">
</head>
<body>
    <div class="container">
        <h1>📋 Seus Pedidos</h1>
        <a href="menu.php">Voltar ao Menu</a><br><br>

        <?php if (empty($pedidos)): ?>
            <p>⚠️ Você ainda não fez nenhum pedido.</p>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido">
                    <h3><?= htmlspecialchars($pedido->nome) ?></h3>
                    <strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido->data)) ?><br>
                    
                    <?php if (!empty($usuarioObj) && !empty($usuarioObj->endereco)): ?>
                        <strong>Endereço:</strong> <?= htmlspecialchars($usuarioObj->endereco) ?><br>
                    <?php endif; ?>
                    
                    <strong>Status atual:</strong> <?= htmlspecialchars($pedido->status) ?><br>

                    <?php
                    // Buscar produtos do pedido
                    $pedidoId = $pedido->id;
                    $produtos = $db->select("SELECT * FROM pedido_produto WHERE pedido_id = $pedidoId");
                    ?>

                    <h4>Produtos:</h4>
                    <ul>
                        <?php foreach ($produtos as $produto): ?>
                            <li>
                                <?= htmlspecialchars($produto->nome_produto) ?> 
                                (<?= $produto->quantidade ?>x) 
                                - R$ <?= number_format($produto->preco, 2, ',', '.') ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
