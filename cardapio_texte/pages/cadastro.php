<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../assets/estilo-login.css">
  <title>Cadastro</title>
</head>
<body>
  <h2>Cadastro de Usuário</h2>
  <form method="POST" action="../scripts/processa_cadastro.php">
    <input type="text" name="usuario" placeholder="Usuário" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button type="submit">Cadastrar</button>
  </form>
  <br>
  <button onclick="window.location.href='login.php'">Já tem conta? Faça login</button> 
</body>
</html>