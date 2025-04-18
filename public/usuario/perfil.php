<?php
// Desempacotar os dados recebidos
$usuario = $parametro['usuario'] ?? [];
$avaliacoes = $parametro['avaliacoes'] ?? [];

// Inicializa a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuarioId = $_SESSION['usuario_id'] ?? 0;
$usuarioNome = $_SESSION['usuario_nome'] ?? '';
$usuarioEmail = $_SESSION['usuario_email'] ?? '';
?>

<div class="perfil-container">
    <div class="perfil-columns">
        <!-- Coluna de informações do usuário -->
        <div class="perfil-column informacoes">
            <h2>Olá <?= $usuarioNome ?></h2>
            
            <div class="perfil-secao">
                <h3>Minhas Informações</h3>
                <div class="perfil-campo">
                    <span class="campo-titulo">Nome</span>
                    <span class="campo-valor"><?= $usuario['nome'] ?></span>
                </div>
                <div class="perfil-campo">
                    <span class="campo-titulo">E-mail</span>
                    <span class="campo-valor"><?= $usuario['email'] ?></span>
                </div>
            </div>
            
            <div class="perfil-acoes">
                <a href="#" onclick="abrirModalEditarInfo()" class="btn-perfil">Editar minhas informações</a>
                <a href="#" onclick="abrirModalSenha()" class="btn-perfil">Alterar Senha</a>
                <a href="#" onclick="confirmarExclusaoConta()" class="btn-perfil btn-excluir">Excluir Conta</a>
            </div>
        </div>
        
        <!-- Coluna de avaliações -->
        <div class="perfil-column avaliacoes">
            <h2>Avaliações</h2>
            
            <?php if(empty($avaliacoes)): ?>
                <div class="sem-avaliacoes">
                    <p>Você ainda não avaliou nenhum produto.</p>
                    <a href="/produto/listar" class="btn-ver-produtos">Ver produtos para avaliar</a>
                </div>
            <?php else: ?>
                <div class="avaliacoes-lista">
                    <?php foreach($avaliacoes as $avaliacao): ?>
                        <div class="avaliacao-item">
                            <div class="avaliacao-imagem">
                                <?php if(!empty($avaliacao['produto_imagem'])): ?>
                                    <img src="<?= $avaliacao['produto_imagem'] ?>" alt="<?= $avaliacao['produto_nome'] ?>">
                                <?php else: ?>
                                    <div class="sem-imagem">
                                        <span>Sem imagem</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="avaliacao-conteudo">
                                <h3 class="produto-nome"><?= $avaliacao['produto_nome'] ?></h3>
                                <div class="avaliacao-stars">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="star <?= ($i <= $avaliacao['nota']) ? 'star-filled' : '' ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                                <p class="avaliacao-comentario"><?= $avaliacao['comentario'] ?></p>
                                <div class="avaliacao-acoes">
                                    <a href="#" onclick="editarAvaliacao(<?= $avaliacao['id'] ?>, <?= $avaliacao['nota'] ?>, '<?= htmlspecialchars($avaliacao['comentario'], ENT_QUOTES) ?>')" class="link-editar">Editar</a>
                                    <a href="#" onclick="confirmarExclusao(<?= $avaliacao['id'] ?>)" class="link-excluir">Excluir</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal para editar avaliação -->
<div id="modal-editar-avaliacao" class="modal">
    <div class="modal-content">
        <span class="fechar-modal" onclick="fecharModal('modal-editar-avaliacao')">&times;</span>
        <h2>Editar Avaliação</h2>
        
        <form id="form-editar-avaliacao" method="POST" action="/feedback/adicionar_ajax">
            <input type="hidden" id="avaliacao_id" name="id" value="">
            <input type="hidden" name="produto_id" value="">
            <input type="hidden" name="usuario_id" value="<?= $usuarioId ?>">
            
            <div class="form-group">
                <label>Sua nota:</label>
                <div class="avaliacao-estrelas">
                    <?php for($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" id="edicao_estrela<?= $i ?>" name="nota" value="<?= $i ?>" required>
                        <label for="edicao_estrela<?= $i ?>" class="estrela-label">★</label>
                    <?php endfor; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="edicao_comentario">Seu comentário:</label>
                <textarea id="edicao_comentario" name="comentario" class="form-control" required></textarea>
            </div>
            
            <div class="form-group text-center">
                <button type="submit" class="btn-enviar-avaliacao">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para editar informações do usuário -->
<div id="modal-editar-info" class="modal">
    <div class="modal-content">
        <span class="fechar-modal" onclick="fecharModal('modal-editar-info')">&times;</span>
        <h2>Editar Informações</h2>
        
        <form id="form-editar-info" method="POST" action="/usuario/editar_ajax">
            <input type="hidden" name="id" value="<?= $usuarioId ?>">
            
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?= $usuario['nome'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= $usuario['email'] ?>" required>
            </div>
            
            <div class="form-group text-center">
                <button type="submit" class="btn-enviar-avaliacao">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para alterar senha -->
<div id="modal-senha" class="modal">
    <div class="modal-content">
        <span class="fechar-modal" onclick="fecharModal('modal-senha')">&times;</span>
        <h2>Alterar Senha</h2>
        
        <form id="form-alterar-senha" method="POST" action="/usuario/alterar_senha_ajax">
            <input type="hidden" name="id" value="<?= $usuarioId ?>">
            
            <div class="form-group">
                <label for="senha_atual">Senha Atual:</label>
                <input type="password" id="senha_atual" name="senha_atual" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="nova_senha">Nova Senha:</label>
                <input type="password" id="nova_senha" name="nova_senha" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="confirmar_senha">Confirmar Nova Senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control" required>
            </div>
            
            <div class="form-group text-center">
                <button type="submit" class="btn-enviar-avaliacao">Alterar Senha</button>
            </div>
        </form>
    </div>
</div>

<script>
// Funções para manipular os modais
function abrirModal(id) {
    const modal = document.getElementById(id);
    modal.style.display = 'block';
    setTimeout(() => {
        modal.classList.add('aberto');
    }, 10);
}

function fecharModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('aberto');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

function abrirModalEditarInfo() {
    abrirModal('modal-editar-info');
}

function abrirModalSenha() {
    abrirModal('modal-senha');
}

// Funções para manipular avaliações
function editarAvaliacao(id, nota, comentario) {
    document.getElementById('avaliacao_id').value = id;
    
    // Selecionar a nota correta
    document.querySelector(`#edicao_estrela${nota}`).checked = true;
    
    // Preencher o comentário
    document.getElementById('edicao_comentario').value = comentario;
    
    // Abrir o modal
    abrirModal('modal-editar-avaliacao');
}

function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir esta avaliação?')) {
        // Enviar solicitação para excluir a avaliação
        fetch(`/feedback/excluir_ajax?id=${id}`, {
            method: 'POST',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Recarregar a página para mostrar as mudanças
                location.reload();
            } else {
                alert(data.message || 'Ocorreu um erro ao excluir a avaliação.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Ocorreu um erro ao excluir a avaliação.');
        });
    }
}

function confirmarExclusaoConta() {
    if (confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.')) {
        if (confirm('Todos os seus dados e avaliações serão removidos permanentemente. Deseja continuar?')) {
            window.location.href = "/usuario/excluir?id=<?= $usuarioId ?>";
        }
    }
}

// Fechar modais ao clicar fora
window.onclick = function(event) {
    const modals = document.getElementsByClassName('modal');
    for (let modal of modals) {
        if (event.target == modal) {
            const modalId = modal.getAttribute('id');
            fecharModal(modalId);
        }
    }
}

// Formulário para editar avaliação
document.getElementById('form-editar-avaliacao').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/feedback/editar_ajax', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fecharModal('modal-editar-avaliacao');
            location.reload();
        } else {
            alert(data.message || 'Ocorreu um erro ao atualizar sua avaliação.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Ocorreu um erro ao atualizar sua avaliação.');
    });
});

// Formulário para editar informações do usuário
document.getElementById('form-editar-info').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/usuario/editar_ajax', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fecharModal('modal-editar-info');
            location.reload();
        } else {
            alert(data.message || 'Ocorreu um erro ao atualizar suas informações.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Ocorreu um erro ao atualizar suas informações.');
    });
});

// Formulário para alterar senha
document.getElementById('form-alterar-senha').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const novaSenha = document.getElementById('nova_senha').value;
    const confirmarSenha = document.getElementById('confirmar_senha').value;
    
    if (novaSenha !== confirmarSenha) {
        alert('As senhas não conferem.');
        return;
    }
    
    const formData = new FormData(this);
    
    fetch('/usuario/alterar_senha_ajax', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fecharModal('modal-senha');
            alert('Senha alterada com sucesso!');
        } else {
            alert(data.message || 'Ocorreu um erro ao alterar sua senha.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Ocorreu um erro ao alterar sua senha.');
    });
});
</script>