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

    public function inserirProduto(string $descricao, float $preco, string $imagem) {
        return parent::inserir($descricao, $preco, $imagem);
    }

    public function alterarProduto(int $id, string $descricao, float $preco, string $imagem) {
        return parent::alterar($id, $descricao, $preco, $imagem);
    }

    public function excluirProduto(int $id) {
        return parent::excluir($id);
    }
}