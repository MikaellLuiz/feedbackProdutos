<h2><?= ($parametro != null) ? 'Editar Feedback' : 'Novo Feedback' ?></h2>

<form method="POST" action="index.php?rota=<?= ($parametro != null) ? 'feedback/editar?id=' . $parametro[0]['id'] : 'feedback/novo' ?>">
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Produto:</label>
        <select name="produto_id" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
            <option value="">Selecione um produto</option>
            <?php foreach($produtos as $produto): ?>
                <option value="<?= $produto['id'] ?>" <?= ($parametro != null && $parametro[0]['produto_id'] == $produto['id']) ? 'selected' : '' ?>>
                    <?= substr($produto['descricao'], 0, 50) ?><?= (strlen($produto['descricao']) > 50) ? '...' : '' ?> - R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Usuário:</label>
        <select name="usuario_id" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
            <option value="">Selecione um usuário</option>
            <?php foreach($usuarios as $usuario): ?>
                <option value="<?= $usuario['id'] ?>" <?= ($parametro != null && $parametro[0]['usuario_id'] == $usuario['id']) ? 'selected' : '' ?>>
                    <?= $usuario['nome'] ?> (<?= $usuario['email'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Nota:</label>
        <div style="display: flex; flex-direction: row;">
            <?php for($i = 1; $i <= 5; $i++): ?>
                <div style="margin-right: 15px;">
                    <input type="radio" id="nota<?= $i ?>" name="nota" value="<?= $i ?>" <?= ($parametro != null && $parametro[0]['nota'] == $i) ? 'checked' : '' ?> required>
                    <label for="nota<?= $i ?>"><?= $i ?> <?= ($i == 1) ? 'estrela' : 'estrelas' ?></label>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Comentário:</label>
        <textarea name="comentario" style="width: 100%; padding: 8px; box-sizing: border-box; height: 100px;" required><?= ($parametro != null) ? $parametro[0]['comentario'] : '' ?></textarea>
    </div>
    
    <?php if($parametro != null): ?>
        <input type="hidden" name="id" value="<?= $parametro[0]['id'] ?>" />
    <?php endif; ?>
    
    <div style="margin-top: 20px;">
        <button type="submit" style="padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
            <?= ($parametro != null) ? 'Atualizar' : 'Cadastrar' ?>
        </button>
        <a href="index.php?rota=feedback/lista" style="margin-left: 10px; text-decoration: none; color: #333;">Cancelar</a>
    </div>
</form>