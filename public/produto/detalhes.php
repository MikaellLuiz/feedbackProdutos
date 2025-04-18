<?php
// Desempacotar os dados recebidos do controller
$produto = $parametro['produto'] ?? null;
$feedbacks = $parametro['feedbacks'] ?? [];
$notaMedia = $parametro['nota_media'] ?? 0;
$totalAvaliacoes = $parametro['total_avaliacoes'] ?? 0;

// Formata a nota média para exibição (1 casa decimal)
$notaMediaFormatada = number_format($notaMedia, 1, ',', '.');
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
                    <span>R$ <?= number_format($produto['preco'] * 1.1, 2, ',', '.') ?> em 10x de R$ <?= number_format(($produto['preco'] * 1.1) / 10, 2, ',', '.') ?> sem juros</span>
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
                <a href="/feedback/novo?produto_id=<?= $produto['id'] ?>" class="btn-adicionar-avaliacao">Avaliar Produto</a>
                <a href="/produto/listar" class="btn-voltar">Voltar para Lista</a>
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