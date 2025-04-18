<h2>Feedbacks Cadastrados</h2>

<div style="margin-bottom: 20px;">
    <a href="/feedback/novo" style="padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px;">Novo Feedback</a>
</div>

<?php if(empty($parametro)): ?>
    <p style="text-align: center; padding: 20px; background-color: #f5f5f5; border-radius: 5px;">Nenhum feedback cadastrado</p>
<?php else: ?>
    <?php foreach($parametro as $feedback): ?>
        <div class="feedback-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 20px; background-color: #fff;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <h3 style="margin: 0;"><?= $feedback['produto_descricao'] ?></h3>
                <div class="star-rating">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <span style="color: <?= ($i <= $feedback['nota']) ? 'gold' : '#ccc' ?>;">★</span>
                    <?php endfor; ?>
                </div>
            </div>
            
            <div style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                <strong>Avaliado por:</strong> <?= $feedback['usuario_nome'] ?>
            </div>
            
            <p style="margin: 10px 0; line-height: 1.5;"><?= $feedback['comentario'] ?></p>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px;">
                <a href="/feedback/editar?id=<?= $feedback['id'] ?>" style="padding: 5px 10px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 3px;">Editar</a>
                <a href="/feedback/excluir?id=<?= $feedback['id'] ?>" style="padding: 5px 10px; background-color: #F44336; color: white; text-decoration: none; border-radius: 3px;" onclick="return confirm('Tem certeza que deseja excluir este feedback?')">Excluir</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>