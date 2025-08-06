<?php

require_once "../model/Produto.php";
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}


$total = 0.0;
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../assets/estilo-carrinho.css">
  <title>Carrinho de Compras</title>
</head>
<body>
  <div class="container-principal">
  <h2>🛒 Seu Carrinho</h2>

  <?php if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) === 0): ?>
    <p>Seu carrinho está vazio.</p>
    <a href="menu.php">Voltar ao menu</a>
  <?php else: ?>
    <form method="POST" action="../scripts/finalizar_pedido.php">
      <table align="center" border="1" cellpadding="10">
        <tr>
          <th>Produto</th>
          <th>Preço</th>
          <th>Quantidade</th>
          <th>Subtotal</th>
        </tr>
        <?php foreach ($_SESSION['carrinho'] as $item): 
          $nome = $item->getNome();
          $preco = number_format($item->getPreco());
          $qtd = $item->getQuantidade();
          $subtotal = $preco * $qtd;
          $total += $subtotal;
        ?>
          <tr>
            <td><?= $nome ?></td>
            <td>R$ <?= number_format($preco, 2, ',', '.') ?></td>
            <td><?= $qtd ?></td>
            <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="3"><strong>Total</strong></td>
          <td><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
        </tr>
      </table>

      <br>
      <label>
        <input type="radio" name="entrega" value="local" checked> Consumo no Local
      </label>
      <label>
        <input type="radio" name="entrega" value="delivery"> Delivery
      </label>

      <div id="campo-endereco" style="display: none; margin-top:10px;">
        <input type="text" name="endereco" placeholder="Endereço para entrega">
      </div>

      <br><br>
      <div class="botoes-inferiores">
      <button type="submit" name="acao" value="confirmar">✅ Confirmar Pedido</button>
      <button type="submit" name="acao" value="cancelar">❌ Cancelar</button>
    </form>
      </div>
    </div>

    <script>
      const radioDelivery = document.querySelector('input[value="delivery"]');
      const radioLocal = document.querySelector('input[value="local"]');
      const campoEndereco = document.getElementById('campo-endereco');

      radioDelivery.addEventListener('change', () => campoEndereco.style.display = 'block');
      radioLocal.addEventListener('change', () => campoEndereco.style.display = 'none');
    </script>

  <?php endif; ?>
</body>
</html>