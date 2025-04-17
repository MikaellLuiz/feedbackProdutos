<?php 

namespace CasasLuiza\controller;

use CasasLuiza\service\FeedbackService;
use CasasLuiza\service\ProdutoService;
use CasasLuiza\service\UsuarioService;

class FeedbackController {
    private $feedbackService;
    private $produtoService;
    private $usuarioService;

    public function __construct() {
        $this->feedbackService = new FeedbackService();
        $this->produtoService = new ProdutoService();
        $this->usuarioService = new UsuarioService();
    }

    public function listar() {
        $feedbacks = $this->feedbackService->listarFeedbacks();
        // TODO: implementar template para exibir a lista de feedbacks
        return;
    }

    public function novo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produto_id = intval($_POST['produto_id'] ?? 0);
            $usuario_id = intval($_POST['usuario_id'] ?? 0);
            $nota = intval($_POST['nota'] ?? 0);
            $comentario = $_POST['comentario'] ?? '';
            
            $this->feedbackService->inserirFeedback($produto_id, $usuario_id, $nota, $comentario);
            header('Location: index.php?rota=feedback/lista');
            exit;
        }
        
        $produtos = $this->produtoService->listarProdutos();
        $usuarios = $this->usuarioService->listarUsuarios();
        
        // TODO: implementar template para o formulário de novo feedback
        return;
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produto_id = intval($_POST['produto_id'] ?? 0);
            $usuario_id = intval($_POST['usuario_id'] ?? 0);
            $nota = intval($_POST['nota'] ?? 0);
            $comentario = $_POST['comentario'] ?? '';
            
            $this->feedbackService->alterarFeedback($id, $produto_id, $usuario_id, $nota, $comentario);
            header('Location: index.php?rota=feedback/lista');
            exit;
        }
        
        $feedback = $this->feedbackService->obterFeedbackPorId($id);
        $produtos = $this->produtoService->listarProdutos();
        $usuarios = $this->usuarioService->listarUsuarios();
        
        // TODO: implementar template para o formulário de edição
        return;
    }

    public function excluir() {
        $id = $_GET['id'] ?? 0;
        
        if ($id > 0) {
            $this->feedbackService->excluirFeedback($id);
        }
        
        header('Location: index.php?rota=feedback/lista');
        exit;
    }
}