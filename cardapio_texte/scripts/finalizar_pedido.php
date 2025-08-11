<?php
require_once "../model/Produto.php";
require_once "../model/Pedido.php";
session_start();
require_once "../src/database/Database.php";

// ✅ 1. Verificações iniciais
if (!isset($_SESSION['usuario']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/login.php');
    exit;
}

$acao = $_POST['acao'] ?? null;

if ($acao === 'cancelar') {
    unset($_SESSION['carrinho']);
    echo "❌ Pedido cancelado. <a href='../pages/menu.php'>Voltar ao menu</a>";
    exit;
}

// ✅ 2. Coleta dados da sessão e POST
$usuario = $_SESSION['usuario'];
$carrinho = $_SESSION['carrinho'] ?? [];
$local = $_POST['entrega'];
if (isset($_POST['entrega'])){
    $endereco = $_POST['endereco'];
    $db = new Database();
    $db->update("UPDATE usuarios SET endereco = ? WHERE id = ?", [$endereco, $usuario['id']]);
} else {
    $endereco = null;
}

if (empty($carrinho)) {
    echo "⚠️ Carrinho vazio. <a href='../pages/menu.php'>Voltar</a>";
    exit;
}

// ✅ 3. Dados do pedido
$nomePedido = "Pedido - " . date("Ymd-His");
$dataPedido = date('Y-m-d H:i:s');
$status = "Aguardando confirmação";

// ✅ 4. Conexão com banco
$db = new Database();
$conn = $db->getConnection();

try {
    $conn->beginTransaction();

    // ✅ 5. Inserir pedido na tabela `pedidos`
    $stmt = $conn->prepare("INSERT INTO pedidos (nome, usuario_id, data, status, local) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $nomePedido,
        $usuario['id'],
        $dataPedido,
        $status,
        $local
    ]);
    


    $pedidoId = $conn->lastInsertId();

    // ✅ 6. Inserir produtos do pedido
    $stmtItem = $conn->prepare("INSERT INTO pedido_produto (pedido_id, nome_produto, preco, quantidade) VALUES (?, ?, ?, ?)");

    foreach ($carrinho as $produto) {
        $stmtItem->execute([
            $pedidoId,
            $produto->getNome(),
            $produto->getPreco(),
            $produto->getQuantidade()
        ]);
    }

    $conn->commit();

    // ✅ 7. Limpar carrinho
    unset($_SESSION['carrinho']);

    // ✅ 8. Mensagem de sucesso
    header("Location: ../pages/pedidoSucesso.php");
    echo "
        <h1>✅ Pedido registrado com sucesso!</h1>
        <a href='../pages/menu.php'>Fazer novo pedido</a> | 
        <a href='../pages/status.php'>Ver status</a>
    ";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "❌ Erro ao registrar pedido: " . $e->getMessage();
}
?>
