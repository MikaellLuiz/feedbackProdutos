<?php
namespace CasasLuiza\service;

use CasasLuiza\dao\mysql\ProdutoDAO;

class ProdutoService extends ProdutoDAO {
    public function listarProdutos() {
        return parent::listar();
    }

    public function obterProdutoPorId(int $id) {
        return parent::obterPorId($id);
    }

    public function inserirProduto(string $nome, string $descricao, float $preco, string $imagem) {
        return parent::inserir($nome, $descricao, $preco, $imagem);
    }

    public function alterarProduto(int $id, string $nome, string $descricao, float $preco, string $imagem) {
        return parent::alterar($id, $nome, $descricao, $preco, $imagem);
    }

    public function excluirProduto(int $id) {
        return parent::excluir($id);
    }
}