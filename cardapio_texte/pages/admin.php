<?php
session_start();
if (!isset($_SESSION['usuarioAdmin'])) {
    header('Location: loginAdmin.php');
    exit;
}


require_once "../src/database/Database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $novoStatus = $_POST['status'];

    $db = new Database();
    $pedidos = $db->select("SELECT * FROM pedidos");

    if (isset($pedidos[$index])) {
        $pedidoId = $pedidos[$index]->id;

        // Evitar SQL injection com prepared statements (se suportado)
        $db->update("UPDATE pedidos SET status = ? WHERE id = ?", [$novoStatus, $pedidoId]);
    }

    header('Location: admin.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../assets/estilo-admin.css">
  <title>Painel Admin</title>
</head>
<body>
  <div class="centralizar">
  <h2>🧾 Painel de Pedidos</h2>
    <button onclick="window.location.href = 'cadastroProduto.php'"> Cadastrar Produto </button>
  </div>



  <?php
   $db = new Database();
   $sql = "SELECT * FROM pedidos";
   $pedidos = $db->select($sql);
  
        if (empty($pedidos)): ?>
    <p>Nenhum pedido registrado.</p>
  <?php else: ?>
    <?php foreach ($pedidos as $i => $pedido): ?>
      <div class="card-pedido">
        <?php 
          $usuario_id = $pedido->usuario_id;
          $usuario = $db->select("SELECT * FROM usuarios WHERE id = $usuario_id");
          $nomeUsuario = isset($usuario[0]->nome) ? $usuario[0]->nome : 'Desconhecido';
        ?>
        <strong>Cliente:</strong> <?=htmlspecialchars($nomeUsuario) ?><br>
        <strong>Data:</strong> <?= $pedido->data?><br>
        <strong>Local:</strong> <?= $pedido->local?><br>
        <?php if (!empty($usuario[0]->endereco)): ?>
          <strong>Endereço:</strong> <?= htmlspecialchars($usuario[0]->endereco) ?><br>
        <?php endif; ?>
        <strong>Status atual:</strong> <?= $pedido->status ?><br>

        <form method="POST" style="margin-top: 10px;">
          <input type="hidden" name="index" value="<?= $i ?>">
          <select name="status">
            <option <?= $pedido->status === 'Aguardando confirmação' ? 'selected' : '' ?>>Aguardando confirmação</option>
            <option <?= $pedido->status === 'Em preparo' ? 'selected' : '' ?>>Em preparo</option>
            <option <?= $pedido->status === 'Saiu para entrega' ? 'selected' : '' ?>>Saiu para entrega</option>
            <option <?= $pedido->status === 'Finalizado' ? 'selected' : '' ?>>Finalizado</option>
            <option <?= $pedido->status === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
          </select>
          <button type="submit">Atualizar</button>
        </form>

        <hr>
        <ul style="text-align:left;">
          <?php 
            $pedido_id = $pedido->id;
            $itens = $db->select("SELECT * FROM pedido_produto WHERE pedido_id = $pedido_id");
          ?>
          <?php foreach ($itens as $item): ?>
            <li><?= $item->quantidade ?> <?= $item->nome_produto ?> (R$ <?= number_format($item->preco, 2, ',', '.') ?>)</li>
          <?php endforeach; ?>
        </ul>
        
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
  <div class="centralizar">
  <button onclick="menu.php"><a href="menu.php">Voltar ao Menu</a></button>
  </div>
  

  
</body>
</html>