<h2><?= ($parametro != null) ? 'Editar Produto' : 'Novo Produto' ?></h2>

<form method="POST" action="<?= ($parametro != null) ? '/produto/editar?id=' . $parametro[0]['id'] : '/produto/novo' ?>">
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Descrição:</label>
        <textarea name="descricao" style="width: 100%; padding: 8px; box-sizing: border-box; height: 100px;" required><?= ($parametro != null) ? $parametro[0]['descricao'] : '' ?></textarea>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Preço:</label>
        <input type="number" name="preco" step="0.01" min="0" value="<?= ($parametro != null) ? $parametro[0]['preco'] : '' ?>" style="width: 100%; padding: 8px; box-sizing: border-box;" required />
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">URL da Imagem:</label>
        <input type="text" name="imagem" value="<?= ($parametro != null) ? $parametro[0]['imagem'] : '' ?>" style="width: 100%; padding: 8px; box-sizing: border-box;" placeholder="https://exemplo.com/imagem.jpg" />
    </div>
    
    <?php if($parametro != null): ?>
        <input type="hidden" name="id" value="<?= $parametro[0]['id'] ?>" />
    <?php endif; ?>
    
    <div style="margin-top: 20px;">
        <button type="submit" style="padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
            <?= ($parametro != null) ? 'Atualizar' : 'Cadastrar' ?>
        </button>
        <a href="/produto/listar" style="margin-left: 10px; text-decoration: none; color: #333;">Cancelar</a>
    </div>
</form>