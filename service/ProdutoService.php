<?php
namespace CasasLuiza\service;

use CasasLuiza\dao\mysql\ProdutoDAO;

/**
 * Classe ProdutoService
 * 
 * Implementa os serviços relacionados aos produtos
 * Estende a classe ProdutoDAO para acesso direto às operações de banco de dados
 * 
 * @package CasasLuiza\service
 */
class ProdutoService extends ProdutoDAO {
    /**
     * Lista todos os produtos não excluídos do sistema
     * 
     * @return array Lista de produtos
     */
    public function listarProdutos() {
        return parent::listar();
    }

    /**
     * Obtém um produto específico pelo ID
     * 
     * @param int $id ID do produto a ser obtido
     * @return array Dados do produto
     */
    public function obterProdutoPorId(int $id) {
        return parent::obterPorId($id);
    }

    /**
     * Insere um novo produto no sistema
     * 
     * @param string $nome Nome do produto
     * @param string $descricao Descrição do produto
     * @param float $preco Preço do produto
     * @param string $imagem Caminho para a imagem do produto
     * @return array Resultado da operação
     */
    public function inserirProduto(string $nome, string $descricao, float $preco, string $imagem) {
        return parent::inserir($nome, $descricao, $preco, $imagem);
    }

    /**
     * Altera os dados de um produto existente
     * 
     * @param int $id ID do produto a ser alterado
     * @param string $nome Novo nome do produto
     * @param string $descricao Nova descrição do produto
     * @param float $preco Novo preço do produto
     * @param string $imagem Novo caminho para a imagem do produto
     * @return array Resultado da operação
     */
    public function alterarProduto(int $id, string $nome, string $descricao, float $preco, string $imagem) {
        return parent::alterar($id, $nome, $descricao, $preco, $imagem);
    }

    /**
     * Exclui logicamente um produto do sistema
     * 
     * @param int $id ID do produto a ser excluído
     * @return array Resultado da operação
     */
    public function excluirProduto(int $id) {
        return parent::excluir($id);
    }
    
    /**
     * Obtém todas as avaliações (feedbacks) para um produto específico
     *
     * @param int $produtoId ID do produto
     * @return array Lista de feedbacks do produto
     */
    public function obterFeedbacksDoProduto(int $produtoId) {
        return parent::obterFeedbacks($produtoId);
    }
}