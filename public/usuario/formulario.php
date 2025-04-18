<div class="form-container" style="max-width: 500px; margin: 0 auto; padding: 20px;">
    <h1 class="page-title">Quero criar uma conta</h1>
    
    <form method="POST" action="<?= ($parametro != null) ? '/usuario/editar?id=' . $parametro[0]['id'] : '/usuario/novo' ?>">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite seu Nome" value="<?= ($parametro != null) ? $parametro[0]['nome'] : '' ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Digite seu e-mail" value="<?= ($parametro != null) ? $parametro[0]['email'] : '' ?>" required>
        </div>
        
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" <?= ($parametro == null) ? 'required' : '' ?>>
            <?php if($parametro != null): ?>
            <small style="color: #666; display: block; margin-top: 5px;">Deixe em branco para manter a senha atual</small>
            <?php endif; ?>
        </div>
        
        <?php if($parametro != null || (isset($_SESSION['admin']) && $_SESSION['admin'])): ?>
        <div class="form-group">
            <label>
                <input type="checkbox" name="admin" value="1" <?= ($parametro != null && $parametro[0]['admin'] == 1) ? 'checked' : '' ?>> 
                Administrador
            </label>
        </div>
        <?php else: ?>
            <input type="hidden" name="admin" value="0">
        <?php endif; ?>
        
        <?php if($parametro != null): ?>
            <input type="hidden" name="id" value="<?= $parametro[0]['id'] ?>">
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <?= ($parametro != null) ? 'Atualizar' : 'Continuar' ?>
            </button>
        </div>
    </form>
</div>