<?php
// Define a base URL para uso no XAMPP
$baseUrl = "/feedbackProdutos";

$titulo = empty($parametro) ? 'Novo Produto' : 'Editar Produto';
$produto = empty($parametro) ? null : $parametro[0];
?>

<h2><?= $titulo ?></h2>

<div class="container-form">
    <form method="POST" action="<?= $baseUrl ?><?= empty($produto) ? '/produto/novo' : '/produto/editar?id=' . $produto['id'] ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" class="form-control" value="<?= empty($produto) ? '' : $produto['nome'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4" required><?= empty($produto) ? '' : $produto['descricao'] ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="preco">Preço (R$):</label>
            <input type="number" id="preco" name="preco" class="form-control" step="0.01" min="0" value="<?= empty($produto) ? '' : $produto['preco'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="imagem">Imagem do Produto:</label>
            <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*" <?= empty($produto) ? 'required' : '' ?>>
            
            <?php if(!empty($produto) && !empty($produto['imagem'])): ?>
                <div class="current-image">
                    <p>Imagem atual:</p>
                    <img src="<?= $produto['imagem'] ?>" alt="Imagem atual" style="max-width: 200px; max-height: 200px;">
                    <input type="hidden" name="imagem_atual" value="<?= $produto['imagem'] ?>">
                </div>
            <?php endif; ?>
        </div>
        
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary"><?= empty($produto) ? 'Cadastrar Produto' : 'Atualizar Produto' ?></button>
            <a href="<?= $baseUrl ?>/produto/listar" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>