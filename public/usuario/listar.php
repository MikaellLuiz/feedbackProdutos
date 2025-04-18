<h2>Usuários Cadastrados</h2>

<div style="margin-bottom: 20px;">
    <a href="/usuario/novo" style="padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px;">Novo Usuário</a>
</div>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">ID</th>
            <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Nome</th>
            <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Email</th>
            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Admin</th>
            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($parametro)): ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 10px; border: 1px solid #ddd;">Nenhum usuário cadastrado</td>
            </tr>
        <?php else: ?>
            <?php foreach($parametro as $usuario): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $usuario['id'] ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $usuario['nome'] ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $usuario['email'] ?></td>
                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                        <?= ($usuario['admin'] == 1) ? 'Sim' : 'Não' ?>
                    </td>
                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                        <a href="/usuario/editar?id=<?= $usuario['id'] ?>" style="margin-right: 10px; color: #2196F3; text-decoration: none;">Editar</a>
                        <a href="/usuario/excluir?id=<?= $usuario['id'] ?>" style="color: #F44336; text-decoration: none;" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>