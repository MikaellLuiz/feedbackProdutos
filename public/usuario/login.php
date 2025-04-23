<?php
// Inicializa a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define a base URL para uso no XAMPP
$baseUrl = "/feedbackProdutos";

// Verifica se há mensagem de erro para exibir
$erro = isset($_SESSION['erro_login']) ? $_SESSION['erro_login'] : '';
unset($_SESSION['erro_login']); // Limpa a mensagem após uso

// Verifica se há mensagem de sucesso para exibir
$sucesso = isset($_SESSION['sucesso_registro']) ? $_SESSION['sucesso_registro'] : '';
unset($_SESSION['sucesso_registro']); // Limpa a mensagem após uso
?>

<div class="login-container">
    <h1 class="page-title">Identificação</h1>
    
    <?php if (!empty($sucesso)): ?>
        <div class="success-message"><?= $sucesso ?></div>
    <?php endif; ?>
    
    <div class="login-columns">
        <div class="login-column">
            <h2 class="login-subtitle">Quero criar uma conta</h2>
            
            <form method="POST" action="<?= $baseUrl ?>/usuario/registrar" class="login-form">
                <div class="form-group">
                    <label for="novo-email">E-mail</label>
                    <input type="email" id="novo-email" name="email" class="form-control" placeholder="Digite seu e-mail" required>
                </div>
                
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-full">Continuar</button>
                </div>
            </form>
        </div>
        
        <div class="login-divider"></div>
        
        <div class="login-column">
            <h2 class="login-subtitle">Já sou cliente</h2>
            
            <form method="POST" action="<?= $baseUrl ?>/usuario/autenticar" class="login-form">
                <div class="form-group">
                    <label for="email-login">E-mail</label>
                    <input type="email" id="email-login" name="email" class="form-control" placeholder="Digite seu e-mail" required>
                </div>
                
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
                </div>
                
                <?php if (!empty($erro)): ?>
                    <div class="error-message"><?= $erro ?></div>
                <?php endif; ?>
                
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-full">Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>