<?php 

namespace CasasLuiza\dao\mysql;

use CasasLuiza\dao\IProdutoDAO;
use CasasLuiza\generic\MysqlFactory;

/**
 * Classe ProdutoDAO
 * Implementação MySQL da interface IProdutoDAO para operações de produtos no banco de dados
 */
class ProdutoDAO extends MysqlFactory implements IProdutoDAO {
    /**
     * Lista todos os produtos cadastrados
     * 
     * @return array Lista de todos os produtos
     */
    public function listar() {
        $sql = "SELECT id, nome, descricao, preco, imagem FROM produtos ORDER BY nome";
        return $this->banco->executar($sql);
    }
    
    /**
     * Obtém um produto pelo ID
     * 
     * @param int $id ID do produto
     * @return array Dados do produto
     */
    public function obterPorId(int $id) {
        $sql = "SELECT id, nome, descricao, preco, imagem FROM produtos WHERE id = :id";
        
        $param = [
            ":id" => $id
        ];
        
        return $this->banco->executar($sql, $param);
    }
    
    /**
     * Insere um novo produto no banco de dados
     * 
     * @param string $nome Nome do produto
     * @param string $descricao Descrição do produto
     * @param float $preco Preço do produto
     * @param string $imagem Caminho da imagem do produto
     * @return mixed Resultado da inserção
     */
    public function inserir(string $nome, string $descricao, float $preco, string $imagem) {
        $sql = "INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (:nome, :descricao, :preco, :imagem)";
        
        $param = [
            ":nome" => $nome,
            ":descricao" => $descricao,
            ":preco" => $preco,
            ":imagem" => $imagem
        ];
        
        return $this->banco->executar($sql, $param);
    }

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
    public function alterar(int $id, string $nome, string $descricao, float $preco, string $imagem) {
        $sql = "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, imagem = :imagem WHERE id = :id";
        
        $param = [
            ":id" => $id,
            ":nome" => $nome,
            ":descricao" => $descricao,
            ":preco" => $preco,
            ":imagem" => $imagem
        ];
        
        return $this->banco->executar($sql, $param);
    }

    /**
     * Exclui um produto do banco de dados
     * 
     * @param int $id ID do produto
     * @return mixed Resultado da exclusão
     */
    public function excluir(int $id) {
        $sql = "DELETE FROM produtos WHERE id = :id";
        
        $param = [
            ":id" => $id
        ];
        
        return $this->banco->executar($sql, $param);
    }
    
    /**
     * Obtém os feedbacks de um produto específico
     * 
     * @param int $produtoId ID do produto
     * @return array Lista de feedbacks do produto
     */
    public function obterFeedbacks(int $produtoId) {
        $sql = "SELECT f.id, f.produto_id, f.usuario_id, f.nota, f.comentario, u.nome as usuario_nome
                FROM feedbacks f
                JOIN usuarios u ON f.usuario_id = u.id
                WHERE f.produto_id = :produto_id
                ORDER BY f.id DESC";
                
        $param = [
            ":produto_id" => $produtoId
        ];
        
        return $this->banco->executar($sql, $param);
    }
}