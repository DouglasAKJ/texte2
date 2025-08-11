<?php
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: loginAdmin.php");
    exit();
}
if (isset($_SESSION['usuarioAdmin'])) {
    header('Location: admin.php');
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
  <title>Login Admin</title>
</head>
<body>
  <h2>Painel do Admin</h2>
  <?php if (isset($mensagem)) echo "<p style='color:red;'>$mensagem</p>"; ?>
  <form method="POST" action="../scripts/processa_login_admin.php">
    <input type="text" name="nome" placeholder="Nome" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button type="submit">Entrar</button>
  </form>
  <br>
</body>
</html>