<h2>Avaliações por Produto</h2>

<?php if(empty($parametro)): ?>
    <div class="mensagem-info">
        <p>Nenhuma avaliação encontrada.</p>
        <p>As avaliações só podem ser adicionadas na página de detalhes de cada produto.</p>
    </div>
<?php else: ?>
    <div class="feedback-por-produto-container">
        <?php foreach($parametro as $produtoId => $item): ?>
            <div class="produto-feedback-section">
                <div class="produto-feedback-header">
                    <h3 class="produto-nome">
                        <a href="/produto/detalhes?id=<?= $produtoId ?>">
                            <?= $item['produto']['nome'] ?>
                        </a>
                    </h3>
                    
                    <?php 
                    // Calcular nota média
                    $somaNotas = 0;
                    foreach($item['feedbacks'] as $feedback) {
                        $somaNotas += $feedback['nota'];
                    }
                    $notaMedia = count($item['feedbacks']) > 0 ? $somaNotas / count($item['feedbacks']) : 0;
                    ?>
                    
                    <div class="produto-avaliacao-resumo">
                        <div class="star-rating">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <span class="star <?= ($i <= round($notaMedia)) ? 'star-filled' : '' ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <span class="nota-media"><?= number_format($notaMedia, 1, ',', '.') ?></span>
                        <span class="total-avaliacoes">(<?= count($item['feedbacks']) ?> <?= (count($item['feedbacks']) == 1) ? 'avaliação' : 'avaliações' ?>)</span>
                    </div>
                </div>
                
                <div class="produto-feedback-image">
                    <?php if(!empty($item['produto']['imagem'])): ?>
                        <img src="<?= $item['produto']['imagem'] ?>" alt="<?= $item['produto']['nome'] ?>">
                    <?php else: ?>
                        <div class="produto-sem-imagem">
                            <span>Sem imagem</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="feedback-lista">
                    <?php foreach($item['feedbacks'] as $feedback): ?>
                        <div class="feedback-card">
                            <div class="feedback-header">
                                <div class="feedback-usuario">
                                    <i class="fas fa-user-circle"></i>
                                    <strong><?= $feedback['usuario_nome'] ?></strong>
                                </div>
                                <div class="star-rating">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="star <?= ($i <= $feedback['nota']) ? 'star-filled' : '' ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            
                            <div class="feedback-comentario">
                                <p><?= $feedback['comentario'] ?></p>
                            </div>
                            
                            <?php
                            // Verifica se o usuário está logado e se é administrador
                            $logado = isset($_SESSION['logado']) && $_SESSION['logado'] === true;
                            $isAdmin = $logado && isset($_SESSION['admin']) && $_SESSION['admin'] == 1;
                            $usuarioAtual = $logado ? $_SESSION['usuario_id'] : 0;
                            $ehDonoOuAdmin = $isAdmin || ($logado && $usuarioAtual == $feedback['usuario_id']);
                            
                            if($ehDonoOuAdmin):
                            ?>
                                <div class="feedback-acoes">
                                    <?php if($isAdmin): ?>
                                        <a href="/feedback/excluir?id=<?= $feedback['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir esta avaliação?')">Excluir</a>
                                    <?php endif; ?>
                                    
                                    <?php if($logado && $usuarioAtual == $feedback['usuario_id']): ?>
                                        <a href="/usuario/perfil" class="btn-editar">Gerenciar minhas avaliações</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="produto-feedback-footer">
                    <a href="/produto/detalhes?id=<?= $produtoId ?>" class="btn-ver-produto">Ver detalhes do produto</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.mensagem-info {
    background-color: #f8f9fa;
    border-left: 4px solid #0033B8;
    padding: 15px;
    margin: 20px 0;
    border-radius: 4px;
}

.feedback-por-produto-container {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.produto-feedback-section {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.produto-feedback-header {
    padding: 15px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #eaeaea;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.produto-nome {
    margin: 0;
    font-size: 18px;
}

.produto-nome a {
    color: #0033B8;
    text-decoration: none;
}

.produto-nome a:hover {
    text-decoration: underline;
}

.produto-avaliacao-resumo {
    display: flex;
    align-items: center;
    gap: 8px;
}

.produto-feedback-image {
    width: 100%;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f8f9fa;
    overflow: hidden;
}

.produto-feedback-image img {
    max-width: 100%;
    max-height: 200px;
    object-fit: contain;
}

.produto-sem-imagem {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #eee;
    color: #999;
}

.feedback-lista {
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.feedback-card {
    background-color: #f9f9f9;
    border-radius: 6px;
    padding: 15px;
}

.feedback-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.feedback-usuario {
    display: flex;
    align-items: center;
    gap: 8px;
}

.feedback-comentario {
    margin-top: 10px;
    line-height: 1.5;
}

.feedback-acoes {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #eaeaea;
}

.btn-excluir, .btn-editar {
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
}

.btn-excluir {
    background-color: #f44336;
    color: white;
}

.btn-editar {
    background-color: #2196F3;
    color: white;
}

.produto-feedback-footer {
    padding: 15px;
    border-top: 1px solid #eaeaea;
    text-align: center;
}

.btn-ver-produto {
    display: inline-block;
    padding: 8px 16px;
    background-color: #0033B8;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
}

.btn-ver-produto:hover {
    background-color: #002796;
}

.star-rating {
    display: inline-flex;
}

.star {
    color: #ccc;
    font-size: 18px;
}

.star-filled {
    color: gold;
}

.nota-media {
    font-weight: bold;
}

.total-avaliacoes {
    color: #666;
    font-size: 14px;
}
</style>