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
            header('Location: /usuario/listar');
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
            header('Location: /usuario/listar');
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
        
        header('Location: /usuario/listar');
        exit;
    }
    
    /**
     * Exibe a página de login
     */
    public function login() {
        // Inicializa a sessão se ainda não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->template->layout('/usuario/login.php');
    }
    
    /**
     * Processa a autenticação do usuário
     */
    public function autenticar() {
        // Inicializa a sessão se ainda não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        $resultado = $this->usuarioService->autenticarUsuario($email, $senha);
        
        if ($resultado) {
            // Login bem-sucedido - armazena os dados do usuário na sessão
            $_SESSION['usuario_id'] = $resultado['id'];
            $_SESSION['usuario_nome'] = $resultado['nome'];
            $_SESSION['usuario_email'] = $resultado['email'];
            $_SESSION['admin'] = $resultado['admin'];
            $_SESSION['logado'] = true;
            
            // Redireciona para a página inicial
            header('Location: /');
            exit;
        } else {
            // Login falhou - exibe mensagem de erro
            $_SESSION['erro_login'] = 'E-mail ou senha inválidos. Tente novamente.';
            header('Location: /usuario/login');
            exit;
        }
    }
    
    /**
     * Processa o formulário de registro inicial (apenas email)
     */
    public function registrar() {
        // Inicializa a sessão se ainda não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $email = $_POST['email'] ?? '';
        
        // Verifica se o e-mail já existe
        if ($this->usuarioService->emailExiste($email)) {
            $_SESSION['erro_login'] = 'Este e-mail já está cadastrado. Por favor, faça login.';
            header('Location: /usuario/login');
            exit;
        }
        
        // Armazena o e-mail na sessão e redireciona para o formulário completo
        $_SESSION['novo_email'] = $email;
        header('Location: /usuario/completar_registro');
        exit;
    }
    
    /**
     * Exibe o formulário para completar o registro
     */
    public function completarRegistro() {
        // Inicializa a sessão se ainda não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verifica se há um e-mail na sessão
        if (!isset($_SESSION['novo_email'])) {
            header('Location: /usuario/login');
            exit;
        }
        
        $email = $_SESSION['novo_email'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $senha = $_POST['senha'] ?? '';
            
            // Cria o usuário e limpa a sessão
            $this->usuarioService->inserirUsuario($nome, $email, $senha, false);
            unset($_SESSION['novo_email']);
            
            // Redireciona para o login com mensagem de sucesso
            $_SESSION['sucesso_registro'] = 'Cadastro realizado com sucesso! Por favor, faça login.';
            header('Location: /usuario/login');
            exit;
        }
        
        $this->template->layout('/usuario/completar_registro.php', ['email' => $email]);
    }
    
    /**
     * Realiza o logout do usuário
     */
    public function logout() {
        // Inicializa a sessão se ainda não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Destrói a sessão
        session_destroy();
        
        // Redireciona para a página inicial
        header('Location: /');
        exit;
    }
}
