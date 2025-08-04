<?php
require_once "../src/database/Database.php";
require_once "../model/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $usuario = new Usuario($email, $nome, $senha);

    $db = new Database();

    $sql = 'SELECT * FROM usuarios';

    $lista_usuarios = $db->select($sql, [$email]);

    if(isset($lista_usuarios[$usuario->getEmail()])){
        echo "Email já cadastrado";
        header("Location: cadastro.php");
        exit;
    } else {
        $sqlInsert = "INSERT INTO usuarios VALUES(?, ?, ?)";
        $db->insert($sqlInsert, [$email, $nome, $senha]);
        header("Location: ../pages/login.php");
        exit;
    }

    //$arquivo = '../data/usuarios.json';
    //$dados = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

    

}
?>