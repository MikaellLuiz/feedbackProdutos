<?php

namespace CasasLuiza\controller;

use CasasLuiza\service\UsuarioService;
use CasasLuiza\service\FeedbackService;
use CasasLuiza\template\UsuarioTemplate;

class UsuarioController {
    private $usuarioService;
    private $feedbackService;
    private $template;

    public function __construct() {
        $this->usuarioService = new UsuarioService();
        $this->feedbackService = new FeedbackService();
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
    
    /**
     * Exibe a página de perfil do usuário
     */
    public function perfil() {
        // Inicializa a sessão se ainda não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verifica se o usuário está logado
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: /usuario/login');
            exit;
        }
        
        $usuarioId = $_SESSION['usuario_id'];
        
        // Obtém os dados do usuário
        $usuario = $this->usuarioService->obterUsuarioPorId($usuarioId);
        
        // Obtém as avaliações do usuário
        $avaliacoes = $this->feedbackService->obterFeedbacksPorUsuario($usuarioId);
        
        // Prepara os dados para a view
        $dados = [
            'usuario' => $usuario[0] ?? [],
            'avaliacoes' => $avaliacoes ?? []
        ];
        
        // Exibe a página de perfil
        $this->template->layout('/usuario/perfil.php', $dados);
    }
    
    /**
     * Edita informações do usuário via AJAX
     */
    public function editarAjax() {
        // Inicializa a sessão se ainda não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verifica se o usuário está logado
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->retornarJsonErro('Usuário não autenticado');
            return;
        }
        
        // Verifica se a requisição é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->retornarJsonErro('Método não permitido');
            return;
        }
        
        // Obtém os dados do formulário
        $id = intval($_POST['id'] ?? 0);
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        
        // Verifica se o usuário está editando seu próprio perfil
        if ($id !== $_SESSION['usuario_id']) {
            $this->retornarJsonErro('Você só pode editar seu próprio perfil');
            return;
        }
        
        // Valida os dados
        if ($id <= 0 || empty($nome) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->retornarJsonErro('Dados inválidos');
            return;
        }
        
        // Verifica se o email já existe (exceto para o próprio usuário)
        if ($this->usuarioService->emailExisteOutroUsuario($email, $id)) {
            $this->retornarJsonErro('Este e-mail já está sendo usado por outro usuário');
            return;
        }
        
        try {
            // Obtém o usuário atual para manter a senha e o status de admin
            $usuario = $this->usuarioService->obterUsuarioPorId($id);
            if (empty($usuario)) {
                $this->retornarJsonErro('Usuário não encontrado');
                return;
            }
            
            $senha = $usuario[0]['senha'];
            $admin = $usuario[0]['admin'];
            
            // Atualiza as informações do usuário
            $this->usuarioService->alterarUsuario($id, $nome, $email, $senha, $admin);
            
            // Atualiza os dados de sessão
            $_SESSION['usuario_nome'] = $nome;
            $_SESSION['usuario_email'] = $email;
            
            $this->retornarJsonSucesso('Informações atualizadas com sucesso!');
        } catch (\Exception $e) {
            $this->retornarJsonErro('Erro ao atualizar informações: ' . $e->getMessage());
        }
    }
    
    /**
     * Altera a senha do usuário via AJAX
     */
    public function alterarSenhaAjax() {
        // Inicializa a sessão se ainda não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verifica se o usuário está logado
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->retornarJsonErro('Usuário não autenticado');
            return;
        }
        
        // Verifica se a requisição é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->retornarJsonErro('Método não permitido');
            return;
        }
        
        // Obtém os dados do formulário
        $id = intval($_POST['id'] ?? 0);
        $senhaAtual = $_POST['senha_atual'] ?? '';
        $novaSenha = $_POST['nova_senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';
        
        // Verifica se o usuário está alterando sua própria senha
        if ($id !== $_SESSION['usuario_id']) {
            $this->retornarJsonErro('Você só pode alterar sua própria senha');
            return;
        }
        
        // Valida os dados
        if ($id <= 0 || empty($senhaAtual) || empty($novaSenha) || empty($confirmarSenha)) {
            $this->retornarJsonErro('Todos os campos são obrigatórios');
            return;
        }
        
        if ($novaSenha !== $confirmarSenha) {
            $this->retornarJsonErro('As senhas não conferem');
            return;
        }
        
        try {
            // Verifica se a senha atual está correta
            $usuario = $this->usuarioService->obterUsuarioPorId($id);
            if (empty($usuario) || !password_verify($senhaAtual, $usuario[0]['senha'])) {
                $this->retornarJsonErro('Senha atual incorreta');
                return;
            }
            
            // Hash da nova senha
            $senhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);
            
            // Atualiza a senha do usuário
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
     * Retorna uma resposta JSON de sucesso
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
     */
    private function enviarJsonResponse($dados) {
        header('Content-Type: application/json');
        echo json_encode($dados);
        exit;
    }
}
