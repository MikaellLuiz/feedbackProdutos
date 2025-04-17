<?php

namespace CasasLuiza\controller;

use CasasLuiza\service\UsuarioService;

class UsuarioController {
    private $usuarioService;

    public function __construct() {
        $this->usuarioService = new UsuarioService();
    }

    public function listar() {
        $usuarios = $this->usuarioService->listarUsuarios();
        // TODO: implementar template para exibir a lista de usuários
        return;
    }

    public function novo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $admin = isset($_POST['admin']) ? true : false;
            
            $this->usuarioService->inserirUsuario($nome, $email, $senha, $admin);
            header('Location: index.php?rota=usuario/lista');
            exit;
        }
        
        // TODO: implementar template para o formulário de novo usuário
        return;
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $admin = isset($_POST['admin']) ? true : false;
            
            $this->usuarioService->alterarUsuario($id, $nome, $email, $senha, $admin);
            header('Location: index.php?rota=usuario/lista');
            exit;
        }
        
        $usuario = $this->usuarioService->obterUsuarioPorId($id);
        // TODO: implementar template para o formulário de edição
        return;
    }

    public function excluir() {
        $id = $_GET['id'] ?? 0;
        
        if ($id > 0) {
            $this->usuarioService->excluirUsuario($id);
        }
        
        header('Location: index.php?rota=usuario/lista');
        exit;
    }
}
