<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Feedback de Produtos - Casas Luiza</title>
    <link rel="stylesheet" href="/feedbackProdutos/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php
    // Inicializa a sessão se ainda não estiver iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Base URL para uso no XAMPP
    $baseUrl = "/feedbackProdutos";
    
    // Verifica se o usuário está logado
    $logado = isset($_SESSION['logado']) && $_SESSION['logado'] === true;
    $nomeUsuario = $logado ? $_SESSION['usuario_nome'] : '';
    $isAdmin = $logado && isset($_SESSION['admin']) && $_SESSION['admin'] == 1;
    ?>
    
    <div class="header">
        <div class="header-container">
            <div class="logo-container">
                <img src="<?= $baseUrl ?>/public/img/logo.png" alt="Casas Luiza" class="logo">
            </div>
            <div class="user-info">
                <?php if ($logado): ?>
                    <a href="<?= $baseUrl ?>/usuario/perfil" class="user-profile-link">
                        <span><?= $nomeUsuario ?></span>
                        <div class="user-icon">
                            <i class="fas fa-user"></i>
                        </div>
                    </a>
                    <a href="<?= $baseUrl ?>/usuario/logout" class="logout-link">Sair</a>
                <?php else: ?>
                    <div class="user-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <a href="<?= $baseUrl ?>/usuario/login" class="login-link">Entrar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="navbar">
        <div class="navbar-container">
            <?php if ($isAdmin): ?>
                <a href="<?= $baseUrl ?>/usuario/admin">Painel Admin</a>
            <?php endif; ?>
            <a href="<?= $baseUrl ?>/produto/listar">Produtos</a>
            <a href="<?= $baseUrl ?>/feedback/listar">Feedbacks</a>
            <?php if ($logado): ?>
                <a href="<?= $baseUrl ?>/usuario/perfil">Minha Conta</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
</body>
</html>