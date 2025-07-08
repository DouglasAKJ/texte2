<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $arquivo = '../data/usuarios.json';
    $dados = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

    if (isset($dados[$usuario])) {
        //echo "⚠️ Nome de usuário já existe. <a href='../pages/cadastro.php'>Tente novamente</a>";
        echo "<script> alert('Conta já existente. Tente novamente');
            window.location.href = '../pages/cadastro.php';
        </script>";
        exit;
    }

    $dados[$usuario] = $senha;
    file_put_contents($arquivo, json_encode($dados, JSON_PRETTY_PRINT));
    header("Location: ../pages/login.php");
}
?>