<?php 

namespace CasasLuiza\controller;

use CasasLuiza\service\FeedbackService;
use CasasLuiza\service\ProdutoService;
use CasasLuiza\service\UsuarioService;
use CasasLuiza\template\FeedbackTemplate;

class FeedbackController {
    private $feedbackService;
    private $produtoService;
    private $usuarioService;
    private $template;

    public function __construct() {
        $this->feedbackService = new FeedbackService();
        $this->produtoService = new ProdutoService();
        $this->usuarioService = new UsuarioService();
        $this->template = new FeedbackTemplate();
    }

    /**
     * Lista todos os feedbacks agrupados por produto
     * 
     * @return void
     */
    public function listar() {
        $feedbacks = $this->feedbackService->listarFeedbacks();
        $produtos = $this->produtoService->listarProdutos();
        
        $feedbacksPorProduto = [];
        
        foreach ($produtos as $produto) {
            $feedbacksPorProduto[$produto['id']] = [
                'produto' => $produto,
                'feedbacks' => []
            ];
        }
        
        foreach ($feedbacks as $feedback) {
            if (isset($feedbacksPorProduto[$feedback['produto_id']])) {
                $feedbacksPorProduto[$feedback['produto_id']]['feedbacks'][] = $feedback;
            }
        }
        
        $feedbacksPorProduto = array_filter($feedbacksPorProduto, function($item) {
            return !empty($item['feedbacks']);
        });
        
        $this->template->layout('/feedback/listar.php', $feedbacksPorProduto);
    }

    /**
     * Cria um novo feedback para um produto
     * Verifica se o usuário já avaliou o produto antes de permitir nova avaliação
     * 
     * @return void
     */
    public function novo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produto_id = intval($_POST['produto_id'] ?? 0);
            $usuario_id = intval($_POST['usuario_id'] ?? 0);
            $nota = intval($_POST['nota'] ?? 0);
            $comentario = $_POST['comentario'] ?? '';
            
            if ($this->feedbackService->usuarioJaAvaliouProduto($produto_id, $usuario_id)) {
                $_SESSION['erro_avaliacao'] = 'Você já avaliou este produto. Você pode editar sua avaliação existente na sua área do cliente.';
                header('Location: /produto/detalhes?id=' . $produto_id);
                exit;
            }
            
            $this->feedbackService->inserirFeedback($produto_id, $usuario_id, $nota, $comentario);
            
            header('Location: /produto/detalhes?id=' . $produto_id);
            exit;
        }
        
        global $produtos, $usuarios, $produtoSelecionado;
        $produtos = $this->produtoService->listarProdutos();
        $usuarios = $this->usuarioService->listarUsuarios();
        
        $produtoSelecionado = 0;
        if (isset($_GET['produto_id'])) {
            $produtoSelecionado = intval($_GET['produto_id']);
        }
        
        $this->template->layout('/feedback/formulario.php');
    }

    /**
     * Edita um feedback existente
     * Verifica permissões do usuário antes de permitir a edição
     * 
     * @return void
     */
    public function editar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $id = $_GET['id'] ?? 0;
        
        $feedback = $this->feedbackService->obterFeedbackPorId($id);
        
        if (empty($feedback)) {
            header('Location: /feedback/listar');
            exit;
        }
        
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: /usuario/login');
            exit;
        }
        
        $usuarioId = $_SESSION['usuario_id'];
        $isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] == 1;
        
        if (!$isAdmin && $feedback[0]['usuario_id'] != $usuarioId) {
            header('Location: /feedback/listar');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produto_id = intval($_POST['produto_id'] ?? 0);
            $usuario_id = intval($_POST['usuario_id'] ?? 0);
            $nota = intval($_POST['nota'] ?? 0);
            $comentario = $_POST['comentario'] ?? '';
            
            $this->feedbackService->alterarFeedback($id, $produto_id, $usuario_id, $nota, $comentario);
            header('Location: /feedback/listar');
            exit;
        }
        
        $produtos = $this->produtoService->listarProdutos();
        $usuarios = $this->usuarioService->listarUsuarios();
        
        $dados = [
            'feedback' => $feedback[0],
            'produtos' => $produtos,
            'usuarios' => $usuarios
        ];
        
        $this->template->layout('/feedback/formulario.php', $dados);
    }

    /**
     * Exclui um feedback existente
     * Verifica permissões do usuário antes de permitir a exclusão
     * 
     * @return void
     */
    public function excluir() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $id = $_GET['id'] ?? 0;
        
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: /usuario/login');
            exit;
        }
        
        $feedback = $this->feedbackService->obterFeedbackPorId($id);
        
        if (empty($feedback)) {
            header('Location: /feedback/listar');
            exit;
        }
        
        $usuarioId = $_SESSION['usuario_id'];
        $isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] == 1;
        
        if (!$isAdmin && $feedback[0]['usuario_id'] != $usuarioId) {
            header('Location: /feedback/listar');
            exit;
        }
        
        if ($id > 0) {
            $this->feedbackService->excluirFeedback($id);
        }
        
        header('Location: /feedback/listar');
        exit;
    }
    
    /**
     * Adiciona uma avaliação via AJAX
     * Retorna um JSON com o status da operação
     * 
     * @return void
     */
    public function adicionar_ajax() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->retornarJsonErro('Método não permitido');
            return;
        }
        
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->retornarJsonErro('Usuário não autenticado');
            return;
        }
        
        $produto_id = intval($_POST['produto_id'] ?? 0);
        $usuario_id = intval($_POST['usuario_id'] ?? 0);
        $nota = intval($_POST['nota'] ?? 0);
        $comentario = $_POST['comentario'] ?? '';
        
        if ($produto_id <= 0 || $usuario_id <= 0 || $nota < 1 || $nota > 5 || empty($comentario)) {
            $this->retornarJsonErro('Dados inválidos para avaliação');
            return;
        }
        
        if ($this->feedbackService->usuarioJaAvaliouProduto($produto_id, $usuario_id)) {
            $this->retornarJsonErro('Você já avaliou este produto. Você pode editar sua avaliação existente na sua área do cliente.');
            return;
        }
        
        try {
            $this->feedbackService->inserirFeedback($produto_id, $usuario_id, $nota, $comentario);
            
            $this->retornarJsonSucesso('Avaliação enviada com sucesso!');
        } catch (\Exception $e) {
            $this->retornarJsonErro('Erro ao salvar avaliação: ' . $e->getMessage());
        }
    }
    
    /**
     * Edita uma avaliação via AJAX
     * Retorna um JSON com o status da operação
     * 
     * @return void
     */
    public function editar_ajax() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->retornarJsonErro('Método não permitido');
            return;
        }
        
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->retornarJsonErro('Usuário não autenticado');
            return;
        }
        
        $id = intval($_POST['id'] ?? 0);
        $produto_id = intval($_POST['produto_id'] ?? 0);
        $usuario_id = intval($_POST['usuario_id'] ?? 0);
        $nota = intval($_POST['nota'] ?? 0);
        $comentario = $_POST['comentario'] ?? '';
        
        $feedback = $this->feedbackService->obterFeedbackPorId($id);
        if (empty($feedback) || $feedback[0]['usuario_id'] != $usuario_id) {
            $this->retornarJsonErro('Você não tem permissão para editar esta avaliação');
            return;
        }
        
        if ($id <= 0 || $nota < 1 || $nota > 5 || empty($comentario)) {
            $this->retornarJsonErro('Dados inválidos para avaliação');
            return;
        }
        
        if ($produto_id <= 0) {
            $produto_id = $feedback[0]['produto_id'];
        }
        
        try {
            $this->feedbackService->alterarFeedback($id, $produto_id, $usuario_id, $nota, $comentario);
            
            $this->retornarJsonSucesso('Avaliação atualizada com sucesso!');
        } catch (\Exception $e) {
            $this->retornarJsonErro('Erro ao atualizar avaliação: ' . $e->getMessage());
        }
    }
    
    /**
     * Exclui uma avaliação via AJAX
     * Retorna um JSON com o status da operação
     * 
     * @return void
     */
    public function excluir_ajax() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->retornarJsonErro('Método não permitido');
            return;
        }
        
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->retornarJsonErro('Usuário não autenticado');
            return;
        }
        
        $id = intval($_GET['id'] ?? 0);
        $usuario_id = $_SESSION['usuario_id'];
        
        if ($id <= 0) {
            $this->retornarJsonErro('ID de avaliação inválido');
            return;
        }
        
        $feedback = $this->feedbackService->obterFeedbackPorId($id);
        if (empty($feedback) || $feedback[0]['usuario_id'] != $usuario_id) {
            $this->retornarJsonErro('Você não tem permissão para excluir esta avaliação');
            return;
        }
        
        try {
            $this->feedbackService->excluirFeedback($id);
            
            $this->retornarJsonSucesso('Avaliação excluída com sucesso!');
        } catch (\Exception $e) {
            $this->retornarJsonErro('Erro ao excluir avaliação: ' . $e->getMessage());
        }
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