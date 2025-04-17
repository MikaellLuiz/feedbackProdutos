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
}