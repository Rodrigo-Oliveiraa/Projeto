document.getElementById('form-login').onsubmit = function(event) {
    event.preventDefault(); // Impede o envio tradicional do formulário

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    fetch('http://localhost/meu_projeto/login-processar.php', {
        method: 'POST',
        body: new URLSearchParams({
            email: email,
            password: password
        }),
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // O cabeçalho correto
        }
    })
    .then(response => response.text()) // Espera a resposta como texto
    .then(data => {
       
            window.location.href = 'http://localhost/meu_projeto/carro.html'; // Redireciona para a página de carro
       
    })
    .catch(error => {
        console.error('Erro no login:', error); // Exibe o erro no console
        alert('Erro no login: ' + error); // Alerta o erro para o usuário
    });
};
