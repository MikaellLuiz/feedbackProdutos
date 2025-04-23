<?php
// Inicializa a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário é administrador
$isAdmin = isset($_SESSION['logado']) && $_SESSION['logado'] === true && isset($_SESSION['admin']) && $_SESSION['admin'] == 1;

// Define a base URL para uso no XAMPP
$baseUrl = "/feedbackProdutos";
?>

<div class="container-titulo">
    <h1 class="produtos-titulo">Produtos</h1>

    <?php if($isAdmin): ?>
    <div class="nova-produto-container">
        <a href="<?= $baseUrl ?>/produto/novo" class="btn-novo-produto">Novo Produto</a>
    </div>
    <?php endif; ?>
</div>

<div class="produtos-grid">
    <?php if(empty($parametro)): ?>
        <p class="no-products">Nenhum produto cadastrado</p>
    <?php else: ?>
        <?php foreach($parametro as $produto): ?>
            <div class="produto-card">
                <a href="<?= $baseUrl ?>/produto/detalhes?id=<?= $produto['id'] ?>" class="produto-card-content">
                    <div class="produto-imagem-container">
                        <?php if(!empty($produto['imagem'])): ?>
                            <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>" class="produto-imagem">
                        <?php else: ?>
                            <div class="produto-sem-imagem">
                                <span>Sem imagem</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="produto-info">
                        <h3 class="produto-descricao"><?= substr($produto['descricao'], 0, 50) ?><?= (strlen($produto['descricao']) > 50) ? '...' : '' ?></h3>
                        
                        <div class="produto-precos">
                            <div class="produto-preco-original">
                                <span>R$ <?= number_format($produto['preco'] * 1.1, 2, ',', '.') ?></span>
                            </div>
                            <div class="produto-preco-atual">
                                <span class="preco-prefixo">ou</span>
                                <span class="preco-valor">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                                <span class="preco-sufixo">no Pix</span>
                            </div>
                        </div>
                    </div>
                </a>
                
                <?php if($isAdmin): ?>
                <div class="produto-acoes">
                    <a href="<?= $baseUrl ?>/produto/editar?id=<?= $produto['id'] ?>" class="btn-editar">Editar</a>
                    <a href="<?= $baseUrl ?>/produto/excluir?id=<?= $produto['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>