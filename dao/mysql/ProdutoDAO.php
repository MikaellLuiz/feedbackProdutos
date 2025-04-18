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
}