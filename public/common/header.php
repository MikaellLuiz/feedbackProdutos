<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Feedback de Produtos - Casas Luiza</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <?php
    // Inicializa a sessão se ainda não estiver iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Verifica se o usuário está logado
    $logado = isset($_SESSION['logado']) && $_SESSION['logado'] === true;
    $nomeUsuario = $logado ? $_SESSION['usuario_nome'] : '';
    $isAdmin = $logado && isset($_SESSION['admin']) && $_SESSION['admin'] == 1;
    ?>
    
    <div class="header">
        <div class="header-container">
            <div class="logo-container">
                <img src="/public/img/logo.png" alt="Casas Luiza" class="logo">
            </div>
            <div class="user-info">
                <?php if ($logado): ?>
                    <span>Olá, <?= $nomeUsuario ?></span>
                    <a href="/usuario/logout" class="logout-link">Sair</a>
                <?php else: ?>
                    <a href="/usuario/login" class="login-link">Entrar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="navbar">
        <div class="navbar-container">
            <?php if ($isAdmin): ?>
                <a href="/usuario/listar">Usuários</a>
            <?php endif; ?>
            <a href="/produto/listar">Produtos</a>
            <a href="/feedback/listar">Feedbacks</a>
        </div>
    </div>
    <div class="container">
</body>
</html>