<div class="container-titulo">
    <h1 class="produtos-titulo">Produtos</h1>

    <div class="nova-produto-container">
        <a href="/produto/novo" class="btn-novo-produto">Novo Produto</a>
    </div>
</div>

<div class="produtos-grid">
    <?php if(empty($parametro)): ?>
        <p class="no-products">Nenhum produto cadastrado</p>
    <?php else: ?>
        <?php foreach($parametro as $produto): ?>
            <div class="produto-card">
                <a href="/produto/detalhes?id=<?= $produto['id'] ?>" class="produto-card-content">
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
                
                <div class="produto-acoes">
                    <a href="/produto/editar?id=<?= $produto['id'] ?>" class="btn-editar">Editar</a>
                    <a href="/produto/excluir?id=<?= $produto['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>