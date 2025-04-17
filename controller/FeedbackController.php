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
        $feedbacks = $this->feedbackService->listarFeedbacks();
        $this->template->layout('/feedback/listar.php', $feedbacks);
    }

    public function novo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produto_id = intval($_POST['produto_id'] ?? 0);
            $usuario_id = intval($_POST['usuario_id'] ?? 0);
            $nota = intval($_POST['nota'] ?? 0);
            $comentario = $_POST['comentario'] ?? '';
            
            $this->feedbackService->inserirFeedback($produto_id, $usuario_id, $nota, $comentario);
            header('Location: index.php?rota=feedback/listar');
            exit;
        }
        
        // Preparamos os dados aqui
        global $produtos, $usuarios;
        $produtos = $this->produtoService->listarProdutos();
        $usuarios = $this->usuarioService->listarUsuarios();
        
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
}