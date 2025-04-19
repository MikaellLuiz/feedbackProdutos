<?php

namespace CasasLuiza\dao;

/**
 * Interface IProdutoDAO
 * Define os métodos para operações de produto no banco de dados
 */
interface IProdutoDAO{
    /**
     * Lista todos os produtos cadastrados
     * 
     * @return array Lista de todos os produtos
     */
    public function listar();
    
    /**
     * Obtém um produto pelo ID
     * 
     * @param int $id ID do produto
     * @return array Dados do produto
     */
    public function obterPorId(int $id);
    
    /**
     * Insere um novo produto no banco de dados
     * 
     * @param string $nome Nome do produto
     * @param string $descricao Descrição do produto
     * @param float $preco Preço do produto
     * @param string $imagem Caminho da imagem do produto
     * @return mixed Resultado da inserção
     */
    public function inserir(string $nome, string $descricao, float $preco, string $imagem);
    
    /**
     * Altera um produto existente
     * 
     * @param int $id ID do produto
     * @param string $nome Nome do produto
     * @param string $descricao Descrição do produto
     * @param float $preco Preço do produto
     * @param string $imagem Caminho da imagem do produto
     * @return mixed Resultado da alteração
     */
    public function alterar(int $id, string $nome, string $descricao, float $preco, string $imagem);
    
    /**
     * Exclui um produto do banco de dados
     * 
     * @param int $id ID do produto
     * @return mixed Resultado da exclusão
     */
    public function excluir(int $id);
}