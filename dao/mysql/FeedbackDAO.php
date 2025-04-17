<?php

namespace CasasLuiza\dao\mysql;

use CasasLuiza\dao\IFeedbackDAO;
use CasasLuiza\generic\MysqlFactory;

class FeedbackDAO extends MysqlFactory implements IFeedbackDAO{
    public function listar(){
        $sql = "SELECT f.id, f.produto_id, f.usuario_id, f.nota, f.comentario, 
                       p.descricao as produto_descricao, u.nome as usuario_nome
                FROM feedbacks f
                JOIN produtos p ON f.produto_id = p.id
                JOIN usuarios u ON f.usuario_id = u.id";
        return $this->banco->executar($sql);
    }
    
    public function obterPorId(int $id){
        $sql = "SELECT id, produto_id, usuario_id, nota, comentario
                FROM feedbacks
                WHERE id = :id";

        $param = [
            ":id" => $id
        ];
        
        return $this->banco->executar($sql, $param);
    }
    
    public function inserir(int $produto_id, int $usuario_id, int $nota, string $comentario){
        $sql = "INSERT INTO feedbacks (produto_id, usuario_id, nota, comentario) 
                VALUES (:produto_id, :usuario_id, :nota, :comentario)";

        $param = [
            ":produto_id" => $produto_id,
            ":usuario_id" => $usuario_id,
            ":nota" => $nota,
            ":comentario" => $comentario
        ];

        return $this->banco->executar($sql, $param);
    }

    public function alterar(int $id, int $produto_id, int $usuario_id, int $nota, string $comentario){
        $sql = "UPDATE feedbacks 
                SET produto_id = :produto_id, 
                    usuario_id = :usuario_id, 
                    nota = :nota, 
                    comentario = :comentario 
                WHERE id = :id";

        $param = [
            ":id" => $id,
            ":produto_id" => $produto_id,
            ":usuario_id" => $usuario_id,
            ":nota" => $nota,
            ":comentario" => $comentario
        ];

        return $this->banco->executar($sql, $param);
    }

    public function excluir(int $id){
        $sql = "DELETE FROM feedbacks WHERE id = :id";

        $param = [
            ":id" => $id
        ];

        return $this->banco->executar($sql, $param);
    }
}