<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
$produtos = json_decode(file_get_contents('../data/produtos.json'), true);
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../assets/estilo-menu.css">
  <title>Menu da Lancheria</title>
</head>
<body>
  <main class="container-principal">
    <h2>Olá, <?php echo htmlspecialchars($_SESSION['usuario']); ?>! Escolha seu pedido:</h2>

    <form method="POST" action="../scripts/adicionar_ao_carrinho.php">
      <table cellpadding="10">
        <tr>
          <th>Produto</th>
          <th>Categoria</th>
          <th>Preço</th>
          <th>Quantidade</th>
          <th></th>
        </tr>
        <?php foreach ($produtos as $p): ?>
          <tr>
            <td><?php echo $p['nome']; ?></td>
            <td><?php echo ucfirst($p['categoria']); ?></td>
            <td>R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></td>
            <td>
              <input type="number" name="quantidade[<?php echo $p['id']; ?>]" value="1" min="1" style="width:50px;">
            </td>
            <td>
              <button type="submit" name="adicionar" value="<?php echo $p['id']; ?>">Adicionar</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </form>

    <br>
    <div class="botoes-inferiores">
      <button onclick="window.location.href='carrinho.php'"> 🛒 Ver Carrinho </button>
      <button onclick="window.location.href='login.php?logout=1'"> Sair </button>
    </div>
  </main>
</body>
</html>