<?php

namespace CasasLuiza\controller;

use CasasLuiza\service\UsuarioService;
use CasasLuiza\service\FeedbackService;
use CasasLuiza\template\UsuarioTemplate;

class UsuarioController {
    private $usuarioService;
    private $feedbackService;
    private $template;
    private $baseUrl;

    public function __construct() {
        $this->usuarioService = new UsuarioService();
        $this->feedbackService = new FeedbackService();
        $this->template = new UsuarioTemplate();
        $this->baseUrl = "/feedbackProdutos"; // Base URL para uso no XAMPP
    }

    // Método auxiliar para redirecionamento
    private function redirect($path) {
        header("Location: {$this->baseUrl}{$path}");
        exit;
    }

    /**
     * Lista todos os usuários cadastrados no sistema
     * 
     * @return void
     */
    public function listar() {
        $usuarios = $this->usuarioService->listarUsuarios();
        $this->template->layout('/usuario/listar.php', $usuarios);
    }

    /**
     * Exibe o formulário para criação de um novo usuário e processa o envio do formulário
     * 
     * @return void
     */
    public function novo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $admin = isset($_POST['admin']) ? true : false;
            
            $this->usuarioService->inserirUsuario($nome, $email, $senha, $admin);
            $this->redirect('/usuario/listar');
        }
        
        $this->template->layout('/usuario/formulario.php');
    }

    /**
     * Exibe o formulário para edição de um usuário existente e processa o envio do formulário
     * 
     * @return void
     */
    public function editar() {
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $admin = isset($_POST['admin']) ? true : false;
            
            $this->usuarioService->alterarUsuario($id, $nome, $email, $senha, $admin);
            $this->redirect('/usuario/listar');
        }
        
        $usuario = $this->usuarioService->obterUsuarioPorId($id);
        $this->template->layout('/usuario/formulario.php', $usuario);
    }

    /**
     * Exclui um usuário pelo ID, com verificações de permissão
     * 
     * @return void
     */
    public function excluir() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $id = $_GET['id'] ?? 0;
        
        if ($id > 0) {
            $usuario = $this->usuarioService->obterUsuarioPorId($id);
            
            if (!empty($usuario) && isset($usuario[0]['admin']) && $usuario[0]['admin']) {
                $_SESSION['erro_exclusao'] = 'Não é permitido excluir usuários administradores.';
                $this->redirect('/usuario/listar');
            }
            
            $this->usuarioService->excluirUsuario($id);
            
            if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $id) {
                session_destroy();
                $this->redirect('/usuario/login');
            }
        }
        
        $this->redirect('/usuario/listar');
    }
    
    /**
     * Exibe a página de login
     * 
     * @return void
     */
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->template->layout('/usuario/login.php');
    }
    
    /**
     * Processa a autenticação do usuário
     * 
     * @return void
     */
    public function autenticar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        $resultado = $this->usuarioService->autenticarUsuario($email, $senha);
        
        if ($resultado) {
            $_SESSION['usuario_id'] = $resultado['id'];
            $_SESSION['usuario_nome'] = $resultado['nome'];
            $_SESSION['usuario_email'] = $resultado['email'];
            $_SESSION['admin'] = $resultado['admin'];
            $_SESSION['logado'] = true;
            
            $this->redirect('/');
        } else {
            $_SESSION['erro_login'] = 'E-mail ou senha inválidos. Tente novamente.';
            $this->redirect('/usuario/login');
        }
    }
    
    /**
     * Processa o formulário de registro inicial (apenas email)
     * 
     * @return void
     */
    public function registrar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $email = $_POST['email'] ?? '';
        
        if ($this->usuarioService->emailExiste($email)) {
            $_SESSION['erro_login'] = 'Este e-mail já está cadastrado. Por favor, faça login.';
            $this->redirect('/usuario/login');
        }
        
        $_SESSION['novo_email'] = $email;
        $this->redirect('/usuario/completar_registro');
    }
    
    /**
     * Exibe o formulário para completar o registro e processa o envio do formulário
     * 
     * @return void
     */
    public function completarRegistro() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['novo_email'])) {
            $this->redirect('/usuario/login');
        }
        
        $email = $_SESSION['novo_email'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $senha = $_POST['senha'] ?? '';
            
            $this->usuarioService->inserirUsuario($nome, $email, $senha, false);
            unset($_SESSION['novo_email']);
            
            $_SESSION['sucesso_registro'] = 'Cadastro realizado com sucesso! Por favor, faça login.';
            $this->redirect('/usuario/login');
        }
        
        $this->template->layout('/usuario/completar_registro.php', ['email' => $email]);
    }
    
    /**
     * Realiza o logout do usuário destruindo a sessão
     * 
     * @return void
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_destroy();
        
        $this->redirect('/');
    }
    
    /**
     * Exibe a página de perfil do usuário com suas informações e avaliações
     * 
     * @return void
     */
    public function perfil() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->redirect('/usuario/login');
        }
        
        $usuarioId = $_SESSION['usuario_id'];
        
        $usuario = $this->usuarioService->obterUsuarioPorId($usuarioId);
        
        $avaliacoes = $this->feedbackService->obterFeedbacksPorUsuario($usuarioId);
        
        $dados = [
            'usuario' => $usuario[0] ?? [],
            'avaliacoes' => $avaliacoes ?? []
        ];
        
        $this->template->layout('/usuario/perfil.php', $dados);
    }
    
    /**
     * Edita informações do usuário via AJAX
     * 
     * @return void
     */
    public function editarAjax() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->retornarJsonErro('Usuário não autenticado');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->retornarJsonErro('Método não permitido');
            return;
        }
        
        $id = intval($_POST['id'] ?? 0);
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        
        if ($id !== $_SESSION['usuario_id']) {
            $this->retornarJsonErro('Você só pode editar seu próprio perfil');
            return;
        }
        
        if ($id <= 0 || empty($nome) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->retornarJsonErro('Dados inválidos');
            return;
        }
        
        if ($this->usuarioService->emailExisteOutroUsuario($email, $id)) {
            $this->retornarJsonErro('Este e-mail já está sendo usado por outro usuário');
            return;
        }
        
        try {
            $usuario = $this->usuarioService->obterUsuarioPorId($id);
            if (empty($usuario)) {
                $this->retornarJsonErro('Usuário não encontrado');
                return;
            }
            
            $senha = $usuario[0]['senha'];
            $admin = $usuario[0]['admin'];
            
            $this->usuarioService->alterarUsuario($id, $nome, $email, $senha, $admin);
            
            $_SESSION['usuario_nome'] = $nome;
            $_SESSION['usuario_email'] = $email;
            
            $this->retornarJsonSucesso('Informações atualizadas com sucesso!');
        } catch (\Exception $e) {
            $this->retornarJsonErro('Erro ao atualizar informações: ' . $e->getMessage());
        }
    }
    
    /**
     * Altera a senha do usuário via AJAX
     * 
     * @return void
     */
    public function alterarSenhaAjax() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->retornarJsonErro('Usuário não autenticado');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->retornarJsonErro('Método não permitido');
            return;
        }
        
        $id = intval($_POST['id'] ?? 0);
        $senhaAtual = $_POST['senha_atual'] ?? '';
        $novaSenha = $_POST['nova_senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';
        
        if ($id !== $_SESSION['usuario_id']) {
            $this->retornarJsonErro('Você só pode alterar sua própria senha');
            return;
        }
        
        if ($id <= 0 || empty($senhaAtual) || empty($novaSenha) || empty($confirmarSenha)) {
            $this->retornarJsonErro('Todos os campos são obrigatórios');
            return;
        }
        
        if ($novaSenha !== $confirmarSenha) {
            $this->retornarJsonErro('As senhas não conferem');
            return;
        }
        
        try {
            $usuario = $this->usuarioService->obterUsuarioPorId($id);
            if (empty($usuario) || !password_verify($senhaAtual, $usuario[0]['senha'])) {
                $this->retornarJsonErro('Senha atual incorreta');
                return;
            }
            
            $senhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);
            
            $this->usuarioService->alterarUsuario(
                $id, 
                $usuario[0]['nome'], 
                $usuario[0]['email'], 
                $senhaCriptografada, 
                $usuario[0]['admin']
            );
            
            $this->retornarJsonSucesso('Senha alterada com sucesso!');
        } catch (\Exception $e) {
            $this->retornarJsonErro('Erro ao alterar senha: ' . $e->getMessage());
        }
    }
    
    /**
     * Exibe a página de painel admin com informações do usuário e lista de usuários
     * 
     * @return void
     */
    public function admin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
            $this->redirect('/');
        }
        
        $usuarioId = $_SESSION['usuario_id'];
        
        $usuario = $this->usuarioService->obterUsuarioPorId($usuarioId);
        
        $avaliacoes = $this->feedbackService->obterFeedbacksPorUsuario($usuarioId);
        
        $todosUsuarios = $this->usuarioService->listarUsuarios();
        
        $dados = [
            'usuario' => $usuario[0] ?? [],
            'avaliacoes' => $avaliacoes ?? [],
            'todos_usuarios' => $todosUsuarios ?? []
        ];
        
        $this->template->layout('/usuario/admin.php', $dados);
    }
    
    /**
     * Retorna uma resposta JSON de sucesso
     * 
     * @param string $mensagem Mensagem de sucesso
     * @param array $dados Dados adicionais a serem retornados
     * @return void
     */
    private function retornarJsonSucesso($mensagem = '', $dados = []) {
        $resposta = [
            'success' => true,
            'message' => $mensagem
        ];
        
        if (!empty($dados)) {
            $resposta['data'] = $dados;
        }
        
        $this->enviarJsonResponse($resposta);
    }
    
    /**
     * Retorna uma resposta JSON de erro
     * 
     * @param string $mensagem Mensagem de erro
     * @param int $codigo Código HTTP de erro
     * @return void
     */
    private function retornarJsonErro($mensagem = '', $codigo = 400) {
        http_response_code($codigo);
        
        $resposta = [
            'success' => false,
            'message' => $mensagem
        ];
        
        $this->enviarJsonResponse($resposta);
    }
    
    /**
     * Envia uma resposta JSON
     * 
     * @param array $dados Dados a serem convertidos para JSON
     * @return void
     */
    private function enviarJsonResponse($dados) {
        header('Content-Type: application/json');
        echo json_encode($dados);
        exit;
    }
}
