<?php
// Desempacotar os dados recebidos do controller
$produto = $parametro['produto'] ?? null;
$feedbacks = $parametro['feedbacks'] ?? [];
$notaMedia = $parametro['nota_media'] ?? 0;
$totalAvaliacoes = $parametro['total_avaliacoes'] ?? 0;

// Formata a nota média para exibição (1 casa decimal)
$notaMediaFormatada = number_format($notaMedia, 1, ',', '.');

// Inicializa a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define a base URL para uso no XAMPP
$baseUrl = "/feedbackProdutos";

// Verifica se o usuário está logado
$logado = isset($_SESSION['logado']) && $_SESSION['logado'] === true;
$usuarioId = $logado ? $_SESSION['usuario_id'] : 0;
$usuarioNome = $logado ? $_SESSION['usuario_nome'] : '';
?>

<div class="produto-detalhes-container">
    <div class="produto-detalhes-header">
        <h1 class="produto-titulo"><?= $produto['nome'] ?></h1>
    </div>

    <div class="produto-detalhes-content">
        <div class="produto-detalhes-imagem-container">
            <?php if(!empty($produto['imagem'])): ?>
                <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>" class="produto-detalhes-imagem">
            <?php else: ?>
                <div class="produto-sem-imagem grande">
                    <span>Sem imagem</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="produto-detalhes-info">
            <div class="produto-detalhes-descricao">
                <h2>Descrição</h2>
                <p><?= $produto['descricao'] ?></p>
            </div>

            <div class="produto-detalhes-precos">
                <div class="produto-preco-original grande">
                    <span class="preco-valor-original">R$ <?= number_format($produto['preco'] * 1.1, 2, ',', '.') ?></span>
                    <span class="preco-parcelamento">em 10x de R$ <?= number_format(($produto['preco'] * 1.1) / 10, 2, ',', '.') ?> sem juros</span>
                </div>
                <div class="produto-preco-atual grande">
                    <span class="preco-valor">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                    <span class="preco-sufixo">no Pix</span>
                </div>
            </div>

            <div class="produto-detalhes-avaliacao-resumo">
                <h3>Avaliações</h3>
                <div class="produto-avaliacao-media">
                    <div class="star-rating grande">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?= ($i <= round($notaMedia)) ? 'star-filled' : '' ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <span class="nota-media"><?= $notaMediaFormatada ?></span>
                    <span class="total-avaliacoes">(<?= $totalAvaliacoes ?> <?= ($totalAvaliacoes == 1) ? 'avaliação' : 'avaliações' ?>)</span>
                </div>
            </div>

            <div class="produto-detalhes-acoes">
                <?php if($logado): ?>
                    <?php 
                    // Verifica se o usuário já avaliou este produto
                    $jaAvaliou = (new \CasasLuiza\service\FeedbackService())->usuarioJaAvaliouProduto($produto['id'], $usuarioId);
                    if($jaAvaliou): 
                    ?>
                        <a href="<?= $baseUrl ?>/usuario/perfil" class="btn-adicionar-avaliacao">Ver Sua Avaliação</a>
                    <?php else: ?>
                        <button class="btn-adicionar-avaliacao" onclick="abrirModal()">Avaliar Produto</button>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?= $baseUrl ?>/usuario/login" class="btn-adicionar-avaliacao">Faça login para avaliar</a>
                <?php endif; ?>
                <a href="<?= $baseUrl ?>/produto/listar" class="btn-voltar">Voltar para Lista</a>
            </div>
        </div>
    </div>

    <div class="produto-detalhes-avaliacoes">
        <h2 class="avaliacoes-titulo">Avaliações</h2>
        
        <?php if(empty($feedbacks)): ?>
            <p class="sem-avaliacoes">Este produto ainda não possui avaliações. Seja o primeiro a avaliar!</p>
        <?php else: ?>
            <div class="avaliacoes-lista">
                <?php foreach($feedbacks as $feedback): ?>
                    <div class="avaliacao-item">
                        <div class="avaliacao-cabecalho">
                            <div class="avaliacao-usuario">
                                <i class="fas fa-user-circle"></i>
                                <strong><?= $feedback['usuario_nome'] ?></strong>
                            </div>
                            <div class="avaliacao-nota">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?= ($i <= $feedback['nota']) ? 'star-filled' : '' ?>">★</span>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="avaliacao-comentario">
                            <p><?= $feedback['comentario'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de Avaliação -->
<div id="modal-avaliacao" class="modal">
    <div class="modal-content">
        <span class="fechar-modal" onclick="fecharModal()">&times;</span>
        <h2>Avaliar <?= $produto['nome'] ?></h2>
        
        <form id="form-avaliacao" method="POST" action="<?= $baseUrl ?>/feedback/adicionar_ajax">
            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
            <input type="hidden" name="usuario_id" value="<?= $usuarioId ?>">
            
            <div class="form-group">
                <label>Sua nota:</label>
                <div class="avaliacao-estrelas">
                    <?php for($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" id="estrela<?= $i ?>" name="nota" value="<?= $i ?>" required>
                        <label for="estrela<?= $i ?>" class="estrela-label">★</label>
                    <?php endfor; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="comentario">Seu comentário:</label>
                <textarea id="comentario" name="comentario" class="form-control" required></textarea>
            </div>
            
            <div class="form-group text-center">
                <button type="submit" class="btn-enviar-avaliacao">Enviar Avaliação</button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal functions
function abrirModal() {
    const modal = document.getElementById('modal-avaliacao');
    modal.style.display = 'block';
    setTimeout(() => {
        modal.classList.add('aberto');
    }, 10);
}

function fecharModal() {
    const modal = document.getElementById('modal-avaliacao');
    modal.classList.remove('aberto');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

// Fechar o modal se clicar fora do conteúdo
window.onclick = function(event) {
    const modal = document.getElementById('modal-avaliacao');
    if (event.target == modal) {
        fecharModal();
    }
}

// Formulário ajax para enviar avaliação sem recarregar a página
document.getElementById('form-avaliacao').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= $baseUrl ?>/feedback/adicionar_ajax', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fecharModal();
            // Recarregar a página para mostrar a nova avaliação
            location.reload();
        } else {
            alert(data.message || 'Ocorreu um erro ao enviar sua avaliação.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Ocorreu um erro ao enviar sua avaliação.');
    });
});
</script>