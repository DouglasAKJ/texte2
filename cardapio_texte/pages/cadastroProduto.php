<?php
session_start();
if (!isset($_SESSION['usuarioAdmin'])) {
    header('Location: loginAdmin.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../assets/estilo-login.css">
  <title>Cadastro de Produto</title>
</head>
<body>
  <h2>Cadastro de Produto</h2>
  <form method="POST" action="../scripts/processa_produto.php">
    <input type="text" name="nome" placeholder="Nome" required><br>
    <input type="number" name="preco" placeholder="Preço" step=".01" required><br>
    <input type="number" name="quantidade" placeholder="quantidade" required><br>
    <button type="submit">Cadastrar</button>
  </form>
  <br>
  <button onclick="window.location.href='admin.php'">Voltar</button> 
</body>
</html>