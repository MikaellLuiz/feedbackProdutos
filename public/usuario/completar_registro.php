<?php
// Verificar se temos o email na sessão
$email = $parametro['email'] ?? '';
?>

<div class="form-container" style="max-width: 500px; margin: 0 auto; padding: 20px;">
    <h1 class="page-title">Complete seu cadastro</h1>
    
    <form method="POST" action="/usuario/completar_registro">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" value="<?= $email ?>" class="form-control" readonly>
            <small style="color: #666; display: block; margin-top: 5px;">Este é o e-mail que você informou.</small>
        </div>
        
        <div class="form-group">
            <label for="nome">Nome completo</label>
            <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite seu nome completo" required>
        </div>
        
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Escolha uma senha segura" required>
            <small style="color: #666; display: block; margin-top: 5px;">Use pelo menos 6 caracteres com letras e números.</small>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                Criar conta
            </button>
        </div>
    </form>
</div>