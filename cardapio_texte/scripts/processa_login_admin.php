<?php
session_start();
require_once "../src/database/Database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $db = new Database();

    // Busca o usuário pelo email
    $sql = "SELECT * FROM usuarios WHERE nome = ?";
    $usuarios = $db->select($sql, [$nome]);

    if (empty($usuarios)) {
        // Email não encontrado
        header("Location: ../pages/loginAdmin.php");
        exit;
    }

    $usuario = $usuarios[0]; // Primeiro resultado

    if ( ($senha == $usuario->senha)) {
        // Senha correta — salva na sessão
        $_SESSION['usuarioAdmin'] = [
            'id' => $usuario->id,
            'nome' => $usuario->nome,
            'email' => $usuario->email
        ];

        header("Location: ../pages/admin.php"); // redireciona para a página protegida
        exit;
    } else {
        // Senha incorreta
        header("Location: ../pages/loginAdmin.php");
        exit;
    }
}
?>