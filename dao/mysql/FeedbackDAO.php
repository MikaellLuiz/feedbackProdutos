<?php

namespace CasasLuiza\dao\mysql;

use CasasLuiza\dao\IFeedbackDAO;
use CasasLuiza\generic\MysqlFactory;

/**
 * Classe FeedbackDAO
 * Implementação MySQL da interface IFeedbackDAO para operações de feedback no banco de dados
 */
class FeedbackDAO extends MysqlFactory implements IFeedbackDAO{
    /**
     * Lista todos os feedbacks cadastrados com informações de produto e usuário
     * 
     * @return array Lista de todos os feedbacks
     */
    public function listar(){
        $sql = "SELECT f.id, f.produto_id, f.usuario_id, f.nota, f.comentario, 
                       p.descricao as produto_descricao, u.nome as usuario_nome
                FROM feedbacks f
                JOIN produtos p ON f.produto_id = p.id
                JOIN usuarios u ON f.usuario_id = u.id";
        return $this->banco->executar($sql);
    }
    
    /**
     * Obtém um feedback pelo ID
     * 
     * @param int $id ID do feedback
     * @return array Dados do feedback
     */
    public function obterPorId(int $id){
        $sql = "SELECT id, produto_id, usuario_id, nota, comentario
                FROM feedbacks
                WHERE id = :id";

        $param = [
            ":id" => $id
        ];
        
        return $this->banco->executar($sql, $param);
    }
    
    /**
     * Insere um novo feedback no banco de dados
     * 
     * @param int $produto_id ID do produto
     * @param int $usuario_id ID do usuário
     * @param int $nota Nota do feedback (1-5)
     * @param string $comentario Comentário do feedback
     * @return mixed Resultado da inserção
     */
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

    /**
     * Altera um feedback existente
     * 
     * @param int $id ID do feedback
     * @param int $produto_id ID do produto
     * @param int $usuario_id ID do usuário
     * @param int $nota Nota do feedback (1-5)
     * @param string $comentario Comentário do feedback
     * @return mixed Resultado da alteração
     */
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

    /**
     * Exclui um feedback do banco de dados
     * 
     * @param int $id ID do feedback
     * @return mixed Resultado da exclusão
     */
    public function excluir(int $id){
        $sql = "DELETE FROM feedbacks WHERE id = :id";

        $param = [
            ":id" => $id
        ];

        return $this->banco->executar($sql, $param);
    }
    
    /**
     * Obtém todos os feedbacks de um usuário específico
     *
     * @param int $usuarioId ID do usuário
     * @return array Lista de feedbacks do usuário
     */
    public function obterPorUsuarioId(int $usuarioId){
        $sql = "SELECT f.id, f.produto_id, f.usuario_id, f.nota, f.comentario, 
                       p.nome as produto_nome, p.descricao as produto_descricao, p.imagem as produto_imagem
                FROM feedbacks f
                JOIN produtos p ON f.produto_id = p.id
                WHERE f.usuario_id = :usuario_id
                ORDER BY f.id DESC";

        $param = [
            ":usuario_id" => $usuarioId
        ];
        
        return $this->banco->executar($sql, $param);
    }

    /**
     * Verifica se um usuário já fez uma avaliação para um produto específico
     *
     * @param int $produto_id ID do produto
     * @param int $usuario_id ID do usuário
     * @return bool True se o usuário já avaliou o produto, False caso contrário
     */
    public function usuarioJaAvaliouProduto(int $produto_id, int $usuario_id) {
        $sql = "SELECT COUNT(*) as total
                FROM feedbacks
                WHERE produto_id = :produto_id AND usuario_id = :usuario_id";

        $param = [
            ":produto_id" => $produto_id,
            ":usuario_id" => $usuario_id
        ];
        
        $resultado = $this->banco->executar($sql, $param);
        
        // Se o resultado for maior que zero, o usuário já avaliou o produto
        return isset($resultado[0]['total']) && $resultado[0]['total'] > 0;
    }
}