<?php
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['usuario'])) {
    header('Location: menu.php');
    exit;
}

if (isset($_GET['erro'])) {
    $mensagem = "⚠️ Usuário ou senha inválidos.";
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../assets/estilo-login.css">
  <title>Login</title>
</head>
<body>
  <h2>Login</h2>
  <?php if (isset($mensagem)) echo "<p style='color:red;'>$mensagem</p>"; ?>
  <form method="POST" action="../scripts/processa_login.php">
    <input type="text" name="usuario" placeholder="Usuário" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button type="submit">Entrar</button>
  </form>
  <br>
  <button onclick="window.location.href='cadastro.php'">Criar nova conta</button>
</body>
</html>