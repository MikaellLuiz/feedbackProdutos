<?php 

namespace CasasLuiza\dao;

interface IFeedbackDAO{
    public function listar();
    public function obterPorId(int $id);
    public function inserir(int $produto_id, int $usuario_id, int $nota, string $comentario);
    public function alterar(int $id, int $produto_id, int $usuario_id, int $nota, string $comentario);
    public function excluir(int $id);
}