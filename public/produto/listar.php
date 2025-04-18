<h2>Produtos Cadastrados</h2>

<div style="margin-bottom: 20px;">
    <a href="/produto/novo" style="padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px;">Novo Produto</a>
</div>

<div class="products-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
    <?php if(empty($parametro)): ?>
        <p style="grid-column: 1 / -1; text-align: center; padding: 20px;">Nenhum produto cadastrado</p>
    <?php else: ?>
        <?php foreach($parametro as $produto): ?>
            <div class="product-card">
                <?php if(!empty($produto['imagem'])): ?>
                    <img src="<?= $produto['imagem'] ?>" alt="<?= substr($produto['descricao'], 0, 30) ?>..." class="product-img" style="max-width: 100%; height: auto; margin-bottom: 10px;">
                <?php else: ?>
                    <div style="height: 100px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                        <span style="color: #999;">Sem imagem</span>
                    </div>
                <?php endif; ?>
                
                <h3 style="margin: 0 0 10px 0;"><?= substr($produto['descricao'], 0, 50) ?><?= (strlen($produto['descricao']) > 50) ? '...' : '' ?></h3>
                <p style="margin: 0 0 15px 0; font-weight: bold; color: #e44d26;">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                
                <div style="display: flex; justify-content: space-between;">
                    <a href="/produto/editar?id=<?= $produto['id'] ?>" style="padding: 5px 10px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 3px;">Editar</a>
                    <a href="/produto/excluir?id=<?= $produto['id'] ?>" style="padding: 5px 10px; background-color: #F44336; color: white; text-decoration: none; border-radius: 3px;" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>