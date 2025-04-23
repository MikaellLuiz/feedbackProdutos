<?php
// Define a base URL para uso no XAMPP
$baseUrl = "/feedbackProdutos";

// Verifica se é edição ou novo feedback
$feedback = isset($parametro['feedback']) ? $parametro['feedback'] : null;
$produtos = isset($parametro['produtos']) ? $parametro['produtos'] : ($produtos ?? []);
$usuarios = isset($parametro['usuarios']) ? $parametro['usuarios'] : ($usuarios ?? []);
$produtoSelecionado = isset($feedback) ? $feedback['produto_id'] : ($produtoSelecionado ?? 0);
?>

<h2><?= isset($feedback) ? 'Editar Avaliação' : 'Nova Avaliação' ?></h2>

<form method="POST" action="<?= $baseUrl ?><?= isset($feedback) ? '/feedback/editar?id=' . $feedback['id'] : '/feedback/novo' ?>" style="max-width: 600px; margin: 20px auto;">
    <div class="form-group">
        <label for="produto_id">Produto:</label>
        <select id="produto_id" name="produto_id" class="form-control" required <?= isset($produtoSelecionado) && $produtoSelecionado > 0 ? 'disabled' : '' ?>>
            <option value="">Selecione um produto</option>
            <?php foreach($produtos as $produto): ?>
                <option value="<?= $produto['id'] ?>" <?= (isset($produtoSelecionado) && $produtoSelecionado == $produto['id']) ? 'selected' : '' ?>><?= $produto['nome'] ?></option>
            <?php endforeach; ?>
        </select>
        <?php if(isset($produtoSelecionado) && $produtoSelecionado > 0): ?>
            <input type="hidden" name="produto_id" value="<?= $produtoSelecionado ?>">
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="usuario_id">Usuário:</label>
        <select id="usuario_id" name="usuario_id" class="form-control" required>
            <option value="">Selecione um usuário</option>
            <?php foreach($usuarios as $usuario): ?>
                <option value="<?= $usuario['id'] ?>" <?= (isset($feedback) && $feedback['usuario_id'] == $usuario['id']) ? 'selected' : '' ?>><?= $usuario['nome'] ?> (<?= $usuario['email'] ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Nota:</label>
        <div class="rating-input">
            <?php for($i = 5; $i >= 1; $i--): ?>
                <input type="radio" id="star<?= $i ?>" name="nota" value="<?= $i ?>" <?= (isset($feedback) && $feedback['nota'] == $i) ? 'checked' : '' ?> required>
                <label for="star<?= $i ?>">★</label>
            <?php endfor; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="comentario">Comentário:</label>
        <textarea id="comentario" name="comentario" class="form-control" rows="4" required><?= isset($feedback) ? $feedback['comentario'] : '' ?></textarea>
    </div>

    <div class="form-group" style="display: flex; justify-content: space-between; margin-top: 20px;">
        <button type="submit" class="btn btn-primary"><?= isset($feedback) ? 'Atualizar Avaliação' : 'Enviar Avaliação' ?></button>
        <a href="<?= $baseUrl ?><?= isset($produtoSelecionado) && $produtoSelecionado > 0 ? '/produto/detalhes?id=' . $produtoSelecionado : '/feedback/listar' ?>" style="margin-left: 10px; text-decoration: none; color: #333;">Cancelar</a>
    </div>
</form>