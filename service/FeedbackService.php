<?php
namespace CasasLuiza\service;

use CasasLuiza\dao\mysql\FeedbackDAO;

class FeedbackService extends FeedbackDAO {
    public function listarFeedbacks() {
        return parent::listar();
    }

    public function obterFeedbackPorId(int $id) {
        return parent::obterPorId($id);
    }

    public function inserirFeedback(int $produto_id, int $usuario_id, int $nota, string $comentario) {
        return parent::inserir($produto_id, $usuario_id, $nota, $comentario);
    }

    public function alterarFeedback(int $id, int $produto_id, int $usuario_id, int $nota, string $comentario) {
        return parent::alterar($id, $produto_id, $usuario_id, $nota, $comentario);
    }

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