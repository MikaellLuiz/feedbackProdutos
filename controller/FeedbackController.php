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

    public function listar() {
        // Obter todos os feedbacks
        $feedbacks = $this->feedbackService->listarFeedbacks();
        
        // Obter todos os produtos com suas informações
        $produtos = $this->produtoService->listarProdutos();
        
        // Agrupar feedbacks por produto
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
        
        // Filtrar apenas produtos que têm feedbacks
        $feedbacksPorProduto = array_filter($feedbacksPorProduto, function($item) {
            return !empty($item['feedbacks']);
        });
        
        // Enviar os dados para o template
        $this->template->layout('/feedback/listar.php', $feedbacksPorProduto);
    }

    public function novo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produto_id = intval($_POST['produto_id'] ?? 0);
            $usuario_id = intval($_POST['usuario_id'] ?? 0);
            $nota = intval($_POST['nota'] ?? 0);
            $comentario = $_POST['comentario'] ?? '';
            
            // Verifica se o usuário já avaliou este produto
            if ($this->feedbackService->usuarioJaAvaliouProduto($produto_id, $usuario_id)) {
                // Redireciona com mensagem de erro
                $_SESSION['erro_avaliacao'] = 'Você já avaliou este produto. Você pode editar sua avaliação existente na sua área do cliente.';
                header('Location: /produto/detalhes?id=' . $produto_id);
                exit;
            }
            
            $this->feedbackService->inserirFeedback($produto_id, $usuario_id, $nota, $comentario);
            
            // Redireciona para os detalhes do produto após adicionar o feedback
            header('Location: /produto/detalhes?id=' . $produto_id);
            exit;
        }
        
        // Preparamos os dados aqui
        global $produtos, $usuarios, $produtoSelecionado;
        $produtos = $this->produtoService->listarProdutos();
        $usuarios = $this->usuarioService->listarUsuarios();
        
        // Verifica se foi passado um ID de produto pela URL
        $produtoSelecionado = 0;
        if (isset($_GET['produto_id'])) {
            $produtoSelecionado = intval($_GET['produto_id']);
        }
        
        // Usamos o método layout do template
        $this->template->layout('/feedback/formulario.php');
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produto_id = intval($_POST['produto_id'] ?? 0);
            $usuario_id = intval($_POST['usuario_id'] ?? 0);
            $nota = intval($_POST['nota'] ?? 0);
            $comentario = $_POST['comentario'] ?? '';
            
            $this->feedbackService->alterarFeedback($id, $produto_id, $usuario_id, $nota, $comentario);
            header('Location: index.php?rota=feedback/listar');
            exit;
        }
        
        // Preparamos os dados aqui
        $feedback = $this->feedbackService->obterFeedbackPorId($id);
        
        // Definimos as variáveis como globais para que o template possa acessá-las
        global $produtos, $usuarios, $parametro;
        $produtos = $this->produtoService->listarProdutos();
        $usuarios = $this->usuarioService->listarUsuarios();
        $parametro = $feedback;
        
        // Usamos o método layout do template
        $this->template->layout('/feedback/formulario.php', $feedback);
    }

    public function excluir() {
        $id = $_GET['id'] ?? 0;
        
        if ($id > 0) {
            $this->feedbackService->excluirFeedback($id);
        }
        
        header('Location: index.php?rota=feedback/listar');
        exit;
    }
    
    /**
     * Adiciona uma avaliação via AJAX
     * Retorna um JSON com o status da operação
     */
    public function adicionar_ajax() {
        // Verifica se a requisição é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->retornarJsonErro('Método não permitido');
            return;
        }
        
        // Verifica se o usuário está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->retornarJsonErro('Usuário não autenticado');
            return;
        }
        
        // Coleta os dados do formulário
        $produto_id = intval($_POST['produto_id'] ?? 0);
        $usuario_id = intval($_POST['usuario_id'] ?? 0);
        $nota = intval($_POST['nota'] ?? 0);
        $comentario = $_POST['comentario'] ?? '';
        
        // Valida os dados
        if ($produto_id <= 0 || $usuario_id <= 0 || $nota < 1 || $nota > 5 || empty($comentario)) {
            $this->retornarJsonErro('Dados inválidos para avaliação');
            return;
        }
        
        // Verifica se o usuário já avaliou este produto
        if ($this->feedbackService->usuarioJaAvaliouProduto($produto_id, $usuario_id)) {
            $this->retornarJsonErro('Você já avaliou este produto. Você pode editar sua avaliação existente na sua área do cliente.');
            return;
        }
        
        // Insere o feedback
        try {
            $this->feedbackService->inserirFeedback($produto_id, $usuario_id, $nota, $comentario);
            
            // Retorna sucesso
            $this->retornarJsonSucesso('Avaliação enviada com sucesso!');
        } catch (\Exception $e) {
            $this->retornarJsonErro('Erro ao salvar avaliação: ' . $e->getMessage());
        }
    }
    
    /**
     * Edita uma avaliação via AJAX
     * Retorna um JSON com o status da operação
     */
    public function editar_ajax() {
        // Verifica se a requisição é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->retornarJsonErro('Método não permitido');
            return;
        }
        
        // Verifica se o usuário está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->retornarJsonErro('Usuário não autenticado');
            return;
        }
        
        // Coleta os dados do formulário
        $id = intval($_POST['id'] ?? 0);
        $produto_id = intval($_POST['produto_id'] ?? 0);
        $usuario_id = intval($_POST['usuario_id'] ?? 0);
        $nota = intval($_POST['nota'] ?? 0);
        $comentario = $_POST['comentario'] ?? '';
        
        // Verifica se o usuário é o dono da avaliação
        $feedback = $this->feedbackService->obterFeedbackPorId($id);
        if (empty($feedback) || $feedback[0]['usuario_id'] != $usuario_id) {
            $this->retornarJsonErro('Você não tem permissão para editar esta avaliação');
            return;
        }
        
        // Valida os dados
        if ($id <= 0 || $nota < 1 || $nota > 5 || empty($comentario)) {
            $this->retornarJsonErro('Dados inválidos para avaliação');
            return;
        }
        
        // Usa o produto_id do feedback existente se não foi fornecido
        if ($produto_id <= 0) {
            $produto_id = $feedback[0]['produto_id'];
        }
        
        // Atualiza o feedback
        try {
            $this->feedbackService->alterarFeedback($id, $produto_id, $usuario_id, $nota, $comentario);
            
            // Retorna sucesso
            $this->retornarJsonSucesso('Avaliação atualizada com sucesso!');
        } catch (\Exception $e) {
            $this->retornarJsonErro('Erro ao atualizar avaliação: ' . $e->getMessage());
        }
    }
    
    /**
     * Exclui uma avaliação via AJAX
     * Retorna um JSON com o status da operação
     */
    public function excluir_ajax() {
        // Verifica se a requisição é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->retornarJsonErro('Método não permitido');
            return;
        }
        
        // Verifica se o usuário está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->retornarJsonErro('Usuário não autenticado');
            return;
        }
        
        // Obtém o ID da avaliação
        $id = intval($_GET['id'] ?? 0);
        $usuario_id = $_SESSION['usuario_id'];
        
        if ($id <= 0) {
            $this->retornarJsonErro('ID de avaliação inválido');
            return;
        }
        
        // Verifica se o usuário é o dono da avaliação
        $feedback = $this->feedbackService->obterFeedbackPorId($id);
        if (empty($feedback) || $feedback[0]['usuario_id'] != $usuario_id) {
            $this->retornarJsonErro('Você não tem permissão para excluir esta avaliação');
            return;
        }
        
        // Exclui o feedback
        try {
            $this->feedbackService->excluirFeedback($id);
            
            // Retorna sucesso
            $this->retornarJsonSucesso('Avaliação excluída com sucesso!');
        } catch (\Exception $e) {
            $this->retornarJsonErro('Erro ao excluir avaliação: ' . $e->getMessage());
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