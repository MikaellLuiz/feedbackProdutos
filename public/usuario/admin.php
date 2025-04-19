<?php
// Desempacotar os dados recebidos
$usuario = $parametro['usuario'] ?? [];
$avaliacoes = $parametro['avaliacoes'] ?? [];
$todosUsuarios = $parametro['todos_usuarios'] ?? [];

// Inicializa a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se é um administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: /');
    exit;
}

$usuarioId = $_SESSION['usuario_id'] ?? 0;
$usuarioNome = $_SESSION['usuario_nome'] ?? '';
$usuarioEmail = $_SESSION['usuario_email'] ?? '';
?>

<div class="admin-dashboard">
    <h1>Painel do Administrador</h1>
    
    <!-- Seção de gerenciamento de usuários -->
    <div class="admin-section usuarios-section">
        <h2>Gerenciamento de Usuários</h2>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($todosUsuarios)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum usuário cadastrado</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($todosUsuarios as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['nome'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td class="text-center">
                                <?= ($user['admin'] == 1) ? 'Sim' : 'Não' ?>
                            </td>
                            <td class="text-center">
                                <?php if ($user['id'] != $usuarioId): ?>
                                    <a href="/usuario/excluir?id=<?= $user['id'] ?>" class="btn-excluir-usuario" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                                <?php else: ?>
                                    <span class="usuario-atual">(Você)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Seção de avaliações no sistema -->
    <div class="admin-section feedback-section">
        <h2>Avaliações no Sistema</h2>
        
        <!-- Adicione um link para ver todas as avaliações -->
        <div class="admin-actions">
            <a href="/feedback/listar" class="btn-admin">Ver todas as avaliações</a>
        </div>
        
        <!-- Aqui você pode adicionar métricas ou resumos de avaliações se desejar -->
    </div>
    
    <!-- Seção de gerenciamento de produtos -->
    <div class="admin-section produtos-section">
        <h2>Gerenciamento de Produtos</h2>
        
        <div class="admin-actions">
            <a href="/produto/listar" class="btn-admin">Ver todos os produtos</a>
            <a href="/produto/novo" class="btn-admin">Adicionar novo produto</a>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.admin-dashboard h1 {
    color: #333;
    margin-bottom: 30px;
    border-bottom: 2px solid #4CAF50;
    padding-bottom: 10px;
}

.admin-section {
    margin-top: 40px;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.admin-table th {
    background-color: #f2f2f2;
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
    font-weight: bold;
}

.admin-table td {
    padding: 12px;
    border: 1px solid #ddd;
}

.admin-table tr:hover {
    background-color: #f9f9f9;
}

.text-center {
    text-align: center;
}

.btn-excluir-usuario {
    display: inline-block;
    padding: 6px 12px;
    background-color: #f44336;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
}

.btn-excluir-usuario:hover {
    background-color: #d32f2f;
}

.admin-badge {
    background-color: #4CAF50;
    color: white;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 14px;
}

.usuario-atual {
    color: #757575;
    font-style: italic;
}

.admin-actions {
    display: flex;
    gap: 15px;
    margin-top: 15px;
}

.btn-admin {
    display: inline-block;
    padding: 10px 15px;
    background-color: #2196F3;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-admin:hover {
    background-color: #0b7dda;
}
</style>