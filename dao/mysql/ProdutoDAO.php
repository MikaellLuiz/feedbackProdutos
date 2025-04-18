<?php 

namespace CasasLuiza\dao\mysql;

use CasasLuiza\dao\IProdutoDAO;
use CasasLuiza\generic\MysqlFactory;

class ProdutoDAO extends MysqlFactory implements IProdutoDAO{
    public function listar(){
        $sql = "SELECT id, nome, descricao, preco, imagem FROM produtos";
        return $this->banco->executar($sql);
    }
    
    public function obterPorId(int $id){
        $sql = "SELECT id, nome, descricao, preco, imagem 
                FROM produtos 
                WHERE id = :id";

        $param = [
            ":id" => $id
        ];
        
        return $this->banco->executar($sql, $param);
    }
    
    public function inserir(string $nome, string $descricao, float $preco, string $imagem){
        $sql = "INSERT INTO produtos (nome, descricao, preco, imagem) 
                VALUES (:nome, :descricao, :preco, :imagem)";

        $param = [
            ":nome" => $nome,
            ":descricao" => $descricao,
            ":preco" => $preco,
            ":imagem" => $imagem
        ];

        return $this->banco->executar($sql, $param);
    }

    public function alterar(int $id, string $nome, string $descricao, float $preco, string $imagem){
        $sql = "UPDATE produtos 
                SET nome = :nome,
                    descricao = :descricao, 
                    preco = :preco, 
                    imagem = :imagem 
                WHERE id = :id";

        $param = [
            ":id" => $id,
            ":nome" => $nome,
            ":descricao" => $descricao,
            ":preco" => $preco,
            ":imagem" => $imagem
        ];

        return $this->banco->executar($sql, $param);
    }

    public function excluir(int $id){
        $sql = "DELETE FROM produtos WHERE id = :id";

        $param = [
            ":id" => $id
        ];

        return $this->banco->executar($sql, $param);
    }
    
    /**
     * Obtém todos os feedbacks de um produto específico
     *
     * @param int $produtoId ID do produto
     * @return array Lista de feedbacks do produto
     */
    public function obterFeedbacksDoProduto(int $produtoId){
        $sql = "SELECT f.id, f.produto_id, f.usuario_id, f.nota, f.comentario, 
                       u.nome as usuario_nome
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