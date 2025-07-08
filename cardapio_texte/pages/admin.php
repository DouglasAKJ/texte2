<?php
session_start();

// Aqui você pode adicionar uma verificação extra para permitir acesso apenas a "admins"
$arquivoPedidos = '../data/pedidos.json';
$pedidos = file_exists($arquivoPedidos) ? json_decode(file_get_contents($arquivoPedidos), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $novoStatus = $_POST['status'];

    if (isset($pedidos[$index])) {
        $pedidos[$index]['status'] = $novoStatus;
        file_put_contents($arquivoPedidos, json_encode($pedidos, JSON_PRETTY_PRINT));
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
  </div>

  <?php if (empty($pedidos)): ?>
    <p>Nenhum pedido registrado.</p>
  <?php else: ?>
    <?php foreach (array_reverse($pedidos, true) as $i => $pedido): ?>
      <div class="card-pedido">
        <strong>Cliente:</strong> <?= htmlspecialchars($pedido['usuario']) ?><br>
        <strong>Data:</strong> <?= $pedido['data'] ?><br>
        <strong>Tipo:</strong> <?= $pedido['entrega'] ?><br>
        <?php if (!empty($pedido['endereco'])): ?>
          <strong>Endereço:</strong> <?= htmlspecialchars($pedido['endereco']) ?><br>
        <?php endif; ?>
        <strong>Status atual:</strong> <?= $pedido['status'] ?><br>

        <form method="POST" style="margin-top: 10px;">
          <input type="hidden" name="index" value="<?= $i ?>">
          <select name="status">
            <option <?= $pedido['status'] === 'Aguardando confirmação' ? 'selected' : '' ?>>Aguardando confirmação</option>
            <option <?= $pedido['status'] === 'Em preparo' ? 'selected' : '' ?>>Em preparo</option>
            <option <?= $pedido['status'] === 'Saiu para entrega' ? 'selected' : '' ?>>Saiu para entrega</option>
            <option <?= $pedido['status'] === 'Finalizado' ? 'selected' : '' ?>>Finalizado</option>
            <option <?= $pedido['status'] === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
          </select>
          <button type="submit">Atualizar</button>
        </form>

        <hr>
        <ul style="text-align:left;">
          <?php foreach ($pedido['itens'] as $item): ?>
            <li><?= $item['quantidade'] ?>× <?= $item['produto']['nome'] ?> (R$ <?= number_format($item['produto']['preco'], 2, ',', '.') ?>)</li>
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