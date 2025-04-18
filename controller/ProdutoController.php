<?php

namespace CasasLuiza\controller;

use CasasLuiza\service\ProdutoService;
use CasasLuiza\template\ProdutoTemplate;

class ProdutoController {
    private $produtoService;
    private $template;

    public function __construct() {
        $this->produtoService = new ProdutoService();
        $this->template = new ProdutoTemplate();
    }

    public function listar() {
        $produtos = $this->produtoService->listarProdutos();
        $this->template->layout('/produto/listar.php', $produtos);
    }

    public function novo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            
            // Processa o upload da imagem
            $imagemPath = $this->processarUploadImagem();
            
            $this->produtoService->inserirProduto($nome, $descricao, $preco, $imagemPath);
            header('Location: /produto/listar');
            exit;
        }
        
        $this->template->layout('/produto/formulario.php');
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            
            // Se foi enviada uma nova imagem, processa o upload
            if (isset($_FILES['imagem']) && $_FILES['imagem']['size'] > 0) {
                $imagemPath = $this->processarUploadImagem();
            } else {
                // Caso contrário, mantém a imagem atual
                $imagemPath = $_POST['imagem_atual'] ?? '';
            }
            
            $this->produtoService->alterarProduto($id, $nome, $descricao, $preco, $imagemPath);
            header('Location: /produto/listar');
            exit;
        }
        
        $produto = $this->produtoService->obterProdutoPorId($id);
        $this->template->layout('/produto/formulario.php', $produto);
    }

    public function excluir() {
        $id = $_GET['id'] ?? 0;
        
        if ($id > 0) {
            $this->produtoService->excluirProduto($id);
        }
        
        header('Location: /produto/listar');
        exit;
    }
    
    /**
     * Processa o upload da imagem do produto
     *
     * @return string Caminho da imagem salva
     */
    private function processarUploadImagem() {
        $imagemPath = '';
        
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            // Diretório para salvar as imagens
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/public/img/produtos/';
            
            // Garante que o diretório existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Gera um nome único para a imagem
            $fileName = 'produto_' . uniqid() . '.png';
            $uploadFile = $uploadDir . $fileName;
            
            // Move o arquivo para o diretório de destino
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
                $imagemPath = '/public/img/produtos/' . $fileName;
            }
        }
        
        return $imagemPath;
    }
}