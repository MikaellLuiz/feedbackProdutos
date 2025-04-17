<?php

namespace CasasLuiza\controller;

use CasasLuiza\service\ProdutoService;

class ProdutoController {
    private $produtoService;

    public function __construct() {
        $this->produtoService = new ProdutoService();
    }

    public function listar() {
        $produtos = $this->produtoService->listarProdutos();
        // TODO: implementar template para exibir a lista de produtos
        return;
    }

    public function novo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            $imagem = $_POST['imagem'] ?? '';
            
            $this->produtoService->inserirProduto($descricao, $preco, $imagem);
            header('Location: index.php?rota=produto/lista');
            exit;
        }
        
        // TODO: implementar template para o formulário de novo produto
        return;
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            $imagem = $_POST['imagem'] ?? '';
            
            $this->produtoService->alterarProduto($id, $descricao, $preco, $imagem);
            header('Location: index.php?rota=produto/lista');
            exit;
        }
        
        $produto = $this->produtoService->obterProdutoPorId($id);
        // TODO: implementar template para o formulário de edição
        return;
    }

    public function excluir() {
        $id = $_GET['id'] ?? 0;
        
        if ($id > 0) {
            $this->produtoService->excluirProduto($id);
        }
        
        header('Location: index.php?rota=produto/lista');
        exit;
    }
}