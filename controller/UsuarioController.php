<?php

namespace CasasLuiza\controller;

use CasasLuiza\service\UsuarioService;
use CasasLuiza\template\UsuarioTemplate;

class UsuarioController {
    private $usuarioService;
    private $template;

    public function __construct() {
        $this->usuarioService = new UsuarioService();
        $this->template = new UsuarioTemplate();
    }

    public function listar() {
        $usuarios = $this->usuarioService->listarUsuarios();
        $this->template->layout('/usuario/listar.php', $usuarios);
    }

    public function novo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $admin = isset($_POST['admin']) ? true : false;
            
            $this->usuarioService->inserirUsuario($nome, $email, $senha, $admin);
            header('Location: index.php?rota=usuario/listar');
            exit;
        }
        
        $this->template->layout('/usuario/formulario.php');
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $admin = isset($_POST['admin']) ? true : false;
            
            $this->usuarioService->alterarUsuario($id, $nome, $email, $senha, $admin);
            header('Location: index.php?rota=usuario/listar');
            exit;
        }
        
        $usuario = $this->usuarioService->obterUsuarioPorId($id);
        $this->template->layout('/usuario/formulario.php', $usuario);
    }

    public function excluir() {
        $id = $_GET['id'] ?? 0;
        
        if ($id > 0) {
            $this->usuarioService->excluirUsuario($id);
        }
        
        header('Location: index.php?rota=usuario/listar');
        exit;
    }
}
