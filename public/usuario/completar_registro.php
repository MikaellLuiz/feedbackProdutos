<?php
// Inicializa a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define a base URL para uso no XAMPP
$baseUrl = "/feedbackProdutos";

// Verifica se há email para registro
if (!isset($_SESSION['novo_email'])) {
    header("Location: {$baseUrl}/usuario/login");
    exit;
}

$email = $parametro['email'] ?? $_SESSION['novo_email'];
?>

<div class="register-container">
    <h1 class="page-title">Complete seu Cadastro</h1>
    
    <form method="POST" action="<?= $baseUrl ?>/usuario/completar_registro" class="register-form">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= $email ?>" readonly>
            <small class="form-text">O e-mail não pode ser alterado nesta etapa.</small>
        </div>
        
        <div class="form-group">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite seu nome completo" required>
        </div>
        
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Crie uma senha" required>
            <small class="form-text">Mínimo de 6 caracteres</small>
        </div>
        
        <div class="form-group">
            <label for="confirmar-senha">Confirmar Senha</label>
            <input type="password" id="confirmar-senha" name="confirmar-senha" class="form-control" placeholder="Confirme sua senha" required>
        </div>
        
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-full">Concluir Cadastro</button>
        </div>
    </form>
</div>

<script>
document.querySelector('.register-form').addEventListener('submit', function(e) {
    const senha = document.getElementById('senha').value;
    const confirmarSenha = document.getElementById('confirmar-senha').value;
    
    if (senha !== confirmarSenha) {
        e.preventDefault();
        alert('As senhas não conferem. Por favor, verifique.');
    }
});
</script>