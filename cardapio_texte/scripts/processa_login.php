<?php
session_start();
require_once "../src/database/Database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $db = new Database();

    // Busca o usuário pelo email
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $usuarios = $db->select($sql, [$email]);

    if (empty($usuarios)) {
        // Email não encontrado
        header("Location: ../pages/login.php");
        exit;
    }

    $usuario = $usuarios[0]; // Primeiro resultado

    if (password_verify($senha, $usuario->senha)) {
        // Senha correta — salva na sessão
        $_SESSION['usuario'] = [
            'id' => $usuario->id,
            'nome' => $usuario->nome,
            'email' => $usuario->email
        ];

        header("Location: ../pages/menu.php"); // redireciona para a página protegida
        exit;
    } else {
        // Senha incorreta
        header("Location: ../pages/login.php");
        exit;
    }
}
?>