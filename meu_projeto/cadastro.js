// Função de validação do formulário
document.getElementById('form-cadastro').onsubmit = function(event) {
    event.preventDefault(); // Impede o envio do formulário, caso haja erro

    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const cpf = document.getElementById('cpf').value.trim();
    const telefone = document.getElementById('telefone').value.trim();
    const dataNascimento = document.getElementById('data-nascimento').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmarSenha = document.getElementById('confirmar-senha').value.trim();

    // Verificando se as senhas coincidem
    if (password !== confirmarSenha) {
        alert('As senhas não coincidem!');
        return;
    }

    // Validação de CPF (14 caracteres após a formatação)
    if (cpf.length !== 14) {
        alert('CPF inválido! Verifique o formato.');
        return;
    }

    // Validação do telefone (15 caracteres após a formatação)
    if (telefone.length !== 15) {
        alert('Telefone inválido! Verifique o formato.');
        return;
    }

    // Validação dos campos obrigatórios
    if (!username || !email || !dataNascimento) {
        alert('Por favor, preencha todos os campos obrigatórios!');
        return;
    }

    // Se todas as validações passarem, o formulário pode ser enviado
    this.submit(); // Agora envia os dados para o PHP processar (criar-conta-processar.php)
};
