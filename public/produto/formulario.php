<div class="container-form">
    <h1 class="page-title">Adicionar / Editar Produto</h1>

    <form method="POST" action="<?= ($parametro != null) ? '/produto/editar?id=' . $parametro[0]['id'] : '/produto/novo' ?>" enctype="multipart/form-data">
        <div class="form-group">
            <input type="text" name="nome" class="form-control" placeholder="Nome" value="<?= ($parametro != null) ? $parametro[0]['nome'] : '' ?>" required>
        </div>
        
        <div class="form-group">
            <input type="text" name="descricao" class="form-control" placeholder="Descrição" value="<?= ($parametro != null) ? $parametro[0]['descricao'] : '' ?>" required>
        </div>
        
        <div class="form-group">
            <input type="number" name="preco" class="form-control" placeholder="Preço" step="0.01" min="0" value="<?= ($parametro != null) ? $parametro[0]['preco'] : '' ?>" required>
        </div>
        
        <div class="form-group">
            <input type="file" name="imagem" id="imagem" class="form-control" placeholder="Selecione uma Imagem">
            <?php if($parametro != null && !empty($parametro[0]['imagem'])): ?>
                <div class="current-image">
                    <p>Imagem atual:</p>
                    <img src="<?= $parametro[0]['imagem'] ?>" alt="Imagem do produto" style="max-width: 150px;">
                    <input type="hidden" name="imagem_atual" value="<?= $parametro[0]['imagem'] ?>">
                </div>
            <?php endif; ?>
        </div>
        
        <?php if($parametro != null): ?>
            <input type="hidden" name="id" value="<?= $parametro[0]['id'] ?>">
        <?php endif; ?>
        
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-full">
                <?= ($parametro != null) ? 'Atualizar' : 'Adicionar' ?>
            </button>
        </div>
    </form>
</div>