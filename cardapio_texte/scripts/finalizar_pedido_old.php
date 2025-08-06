    <?php
session_start();

if (!isset($_SESSION['usuario']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/login.php');
    exit;
}

$acao = $_POST['acao'];

if ($acao === 'cancelar') {
    unset($_SESSION['carrinho']);
    echo "❌ Pedido cancelado. <a href='../pages/menu.php'>Voltar ao menu</a>";
    exit;
}

$usuario = $_SESSION['usuario'];
$carrinho = $_SESSION['carrinho'] ?? [];
$entrega = $_POST['entrega'];
$endereco = $_POST['endereco'] ?? '';

if (empty($carrinho)) {
    echo "⚠️ Carrinho vazio. <a href='../pages/menu.php'>Voltar</a>";
    exit;
}

$pedido = [
    'usuario' => $usuario,
    'itens' => $carrinho,
    'entrega' => $entrega,
    'endereco' => $entrega === 'delivery' ? $endereco : '',
    'status' => 'Aguardando confirmação',
    'data' => date('Y-m-d H:i:s')
];

$arquivoPedidos = '../data/pedidos.json';
$pedidos = file_exists($arquivoPedidos) ? json_decode(file_get_contents($arquivoPedidos), true) : [];

$pedidos[] = $pedido;
file_put_contents($arquivoPedidos, json_encode($pedidos, JSON_PRETTY_PRINT));

unset($_SESSION['carrinho']);

echo "
<h1>✅ Pedido registrado com sucesso! <a href='../pages/menu.php'>Fazer novo pedido</a> | <a href='../pages/status.php'>Ver status</a></h1>;
"

?>
