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
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Preparando a consulta SQL para buscar o usuário com o e-mail fornecido
    $sql = "SELECT * FROM usuarios WHERE email = ?";

    // Preparando a consulta para evitar SQL Injection
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Erro na preparação da consulta SQL: " . $conn->error;
        exit();
    }

    // Ligando o parâmetro à consulta preparada
    $stmt->bind_param("s", $email);

    // Executando a consulta SQL
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificando se o usuário existe
    if ($result->num_rows > 0) {
        // Se o usuário for encontrado, verificamos a senha
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['password'])) {
            // Senha correta, login bem-sucedido, redirecionar para a página de sucesso
            echo "Login bem-sucedido!";
            header("Location: http://localhost/meu_projeto/carro.html");  // Redireciona para a página de carro após login
            exit();
        } else {
            // Senha incorreta
            echo "E-mail ou senha incorretos!";
        }
    } else {
        // E-mail não encontrado
        echo "E-mail ou senha incorretos!";
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>
