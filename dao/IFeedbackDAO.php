<?php

namespace CasasLuiza\dao;

/**
 * Interface IFeedbackDAO
 * Define os métodos para operações de feedback no banco de dados
 */
interface IFeedbackDAO{
    /**
     * Lista todos os feedbacks cadastrados
     * 
     * @return array Lista de todos os feedbacks
     */
    public function listar();
    
    /**
     * Obtém um feedback pelo ID
     * 
     * @param int $id ID do feedback
     * @return array Dados do feedback
     */
    public function obterPorId(int $id);
    
    /**
     * Insere um novo feedback no banco de dados
     * 
     * @param int $produto_id ID do produto
     * @param int $usuario_id ID do usuário
     * @param int $nota Nota do feedback (1-5)
     * @param string $comentario Comentário do feedback
     * @return mixed Resultado da inserção
     */
    public function inserir(int $produto_id, int $usuario_id, int $nota, string $comentario);
    
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
    public function alterar(int $id, int $produto_id, int $usuario_id, int $nota, string $comentario);
    
    /**
     * Exclui um feedback do banco de dados
     * 
     * @param int $id ID do feedback
     * @return mixed Resultado da exclusão
     */
    public function excluir(int $id);
    
    /**
     * Obtém todos os feedbacks de um usuário específico
     * 
     * @param int $usuarioId ID do usuário
     * @return array Lista de feedbacks do usuário
     */
    public function obterPorUsuarioId(int $usuarioId);
    
    /**
     * Verifica se um usuário já fez uma avaliação para um produto específico
     * 
     * @param int $produto_id ID do produto
     * @param int $usuario_id ID do usuário
     * @return bool True se o usuário já avaliou o produto, False caso contrário
     */
    public function usuarioJaAvaliouProduto(int $produto_id, int $usuario_id);
}