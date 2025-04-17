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
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            $imagem = $_POST['imagem'] ?? '';
            
            $this->produtoService->inserirProduto($descricao, $preco, $imagem);
            header('Location: index.php?rota=produto/listar');
            exit;
        }
        
        $this->template->layout('/produto/formulario.php');
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            $imagem = $_POST['imagem'] ?? '';
            
            $this->produtoService->alterarProduto($id, $descricao, $preco, $imagem);
            header('Location: index.php?rota=produto/listar');
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
        
        header('Location: index.php?rota=produto/listar');
        exit;
    }
}