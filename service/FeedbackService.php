<?php
namespace CasasLuiza\service;

use CasasLuiza\dao\mysql\FeedbackDAO;

/**
 * Classe FeedbackService
 * 
 * Implementa os serviços relacionados aos feedbacks (avaliações) de produtos
 * Estende a classe FeedbackDAO para acesso direto às operações de banco de dados
 * 
 * @package CasasLuiza\service
 */
class FeedbackService extends FeedbackDAO {
    /**
     * Lista todos os feedbacks não excluídos do sistema
     * 
     * @return array Lista de feedbacks
     */
    public function listarFeedbacks() {
        return parent::listar();
    }

    /**
     * Obtém um feedback específico pelo ID
     * 
     * @param int $id ID do feedback a ser obtido
     * @return array Dados do feedback
     */
    public function obterFeedbackPorId(int $id) {
        return parent::obterPorId($id);
    }

    /**
     * Insere um novo feedback no sistema
     * 
     * @param int $produto_id ID do produto avaliado
     * @param int $usuario_id ID do usuário que fez a avaliação
     * @param int $nota Nota atribuída ao produto (1-5)
     * @param string $comentario Comentário da avaliação
     * @return array Resultado da operação
     */
    public function inserirFeedback(int $produto_id, int $usuario_id, int $nota, string $comentario) {
        return parent::inserir($produto_id, $usuario_id, $nota, $comentario);
    }

    /**
     * Altera os dados de um feedback existente
     * 
     * @param int $id ID do feedback a ser alterado
     * @param int $produto_id ID do produto avaliado
     * @param int $usuario_id ID do usuário que fez a avaliação
     * @param int $nota Nova nota atribuída ao produto (1-5)
     * @param string $comentario Novo comentário da avaliação
     * @return array Resultado da operação
     */
    public function alterarFeedback(int $id, int $produto_id, int $usuario_id, int $nota, string $comentario) {
        return parent::alterar($id, $produto_id, $usuario_id, $nota, $comentario);
    }

    /**
     * Exclui logicamente um feedback do sistema
     * 
     * @param int $id ID do feedback a ser excluído
     * @return array Resultado da operação
     */
    public function excluirFeedback(int $id) {
        return parent::excluir($id);
    }
    
    /**
     * Obtém todos os feedbacks feitos por um usuário específico
     *
     * @param int $usuarioId ID do usuário
     * @return array Lista de feedbacks do usuário
     */
    public function obterFeedbacksPorUsuario(int $usuarioId) {
        return parent::obterPorUsuarioId($usuarioId);
    }

    /**
     * Verifica se um usuário já avaliou um produto específico
     *
     * @param int $produtoId ID do produto
     * @param int $usuarioId ID do usuário
     * @return bool True se o usuário já avaliou o produto, False caso contrário
     */
    public function usuarioJaAvaliouProduto(int $produtoId, int $usuarioId) {
        return parent::usuarioJaAvaliouProduto($produtoId, $usuarioId);
    }
}