<?php
// Habilita a exibição de erros para facilitar a depuração
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configuração de conexão com o banco de dados (novo banco "novo_sistema")
$servername = "localhost";  // O servidor do banco de dados (no caso do XAMPP, é "localhost")
$username = "root";         // O nome de usuário para o banco de dados (padrão do XAMPP)
$password = "";             // A senha do banco de dados (padrão do XAMPP)
$dbname = "novo_sistema";   // Nome do novo banco de dados

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se houve erro na conexão com o banco
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Coletando os dados do formulário
    $username = $_POST['username'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data-nascimento'];
    $senha = $_POST['password'];
    $confirmar_senha = $_POST['confirmar-senha'];

    // Verificando se as senhas coincidem
    if ($senha !== $confirmar_senha) {
        echo "As senhas não coincidem!";
        exit();
    }

    // Criptografando a senha antes de armazená-la no banco de dados
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara a consulta SQL para inserção dos dados
    $sql = "INSERT INTO usuarios (username, email, cpf, telefone, data_nascimento, password) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Preparando a consulta SQL para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        echo "Erro na preparação da consulta SQL: " . $conn->error;
        exit();
    }

    // Ligando os parâmetros à consulta preparada
    $stmt->bind_param("ssssss", $username, $email, $cpf, $telefone, $data_nascimento, $senha_hash);

    // Executando a consulta SQL
    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
        header("Location: http://localhost/meu_projeto/login-tela.html"); // Redireciona para a página de login após o cadastro
        exit();
    } else {
        echo "Erro ao realizar o cadastro: " . $stmt->error;
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>
