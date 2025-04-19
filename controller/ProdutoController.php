<?php

namespace CasasLuiza\controller;

use CasasLuiza\service\ProdutoService;
use CasasLuiza\service\FeedbackService;
use CasasLuiza\template\ProdutoTemplate;

class ProdutoController {
    private $produtoService;
    private $feedbackService;
    private $template;

    public function __construct() {
        $this->produtoService = new ProdutoService();
        $this->feedbackService = new FeedbackService();
        $this->template = new ProdutoTemplate();
    }

    /**
     * Lista todos os produtos cadastrados no sistema
     * 
     * @return void
     */
    public function listar() {
        $produtos = $this->produtoService->listarProdutos();
        $this->template->layout('/produto/listar.php', $produtos);
    }

    /**
     * Exibe o formulário para criação de um novo produto e processa o envio do formulário
     * Requer que o usuário seja administrador
     * 
     * @return void
     */
    public function novo() {
        session_start();
        if (!isset($_SESSION['logado']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
            header('Location: /produto/listar');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            
            $imagemPath = $this->processarUploadImagem();
            
            $this->produtoService->inserirProduto($nome, $descricao, $preco, $imagemPath);
            header('Location: /produto/listar');
            exit;
        }
        
        $this->template->layout('/produto/formulario.php');
    }

    /**
     * Exibe o formulário para edição de um produto existente e processa o envio do formulário
     * Requer que o usuário seja administrador
     * 
     * @return void
     */
    public function editar() {
        session_start();
        if (!isset($_SESSION['logado']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
            header('Location: /produto/listar');
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            
            if (isset($_FILES['imagem']) && $_FILES['imagem']['size'] > 0) {
                $imagemPath = $this->processarUploadImagem();
            } else {
                $imagemPath = $_POST['imagem_atual'] ?? '';
            }
            
            $this->produtoService->alterarProduto($id, $nome, $descricao, $preco, $imagemPath);
            header('Location: /produto/listar');
            exit;
        }
        
        $produto = $this->produtoService->obterProdutoPorId($id);
        $this->template->layout('/produto/formulario.php', $produto);
    }

    /**
     * Exclui um produto pelo ID
     * Requer que o usuário seja administrador
     * 
     * @return void
     */
    public function excluir() {
        session_start();
        if (!isset($_SESSION['logado']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
            header('Location: /produto/listar');
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        
        if ($id > 0) {
            $this->produtoService->excluirProduto($id);
        }
        
        header('Location: /produto/listar');
        exit;
    }
    
    /**
     * Exibe os detalhes de um produto específico com suas avaliações
     * Calcula a nota média das avaliações e exibe os feedbacks do produto
     * 
     * @return void
     */
    public function detalhes() {
        $id = $_GET['id'] ?? 0;
        
        if ($id <= 0) {
            header('Location: /produto/listar');
            exit;
        }
        
        $produto = $this->produtoService->obterProdutoPorId($id);
        
        if (empty($produto)) {
            header('Location: /produto/listar');
            exit;
        }
        
        $feedbacks = $this->produtoService->obterFeedbacksDoProduto($id);
        
        $notaMedia = 0;
        $totalAvaliacoes = count($feedbacks);
        
        if ($totalAvaliacoes > 0) {
            $somaNotas = 0;
            foreach ($feedbacks as $feedback) {
                $somaNotas += $feedback['nota'];
            }
            $notaMedia = $somaNotas / $totalAvaliacoes;
        }
        
        $dados = [
            'produto' => $produto[0],
            'feedbacks' => $feedbacks,
            'nota_media' => $notaMedia,
            'total_avaliacoes' => $totalAvaliacoes
        ];
        
        $this->template->layout('/produto/detalhes.php', $dados);
    }
    
    /**
     * Processa o upload da imagem do produto
     * Gera um nome único para a imagem e a salva no diretório de imagens
     *
     * @return string Caminho da imagem salva
     */
    private function processarUploadImagem() {
        $imagemPath = '';
        
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/public/img/produtos/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = 'produto_' . uniqid() . '.png';
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
                $imagemPath = '/public/img/produtos/' . $fileName;
            }
        }
        
        return $imagemPath;
    }
}