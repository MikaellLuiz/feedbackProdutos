<?php

namespace CasasLuiza\dao;

interface IProdutoDAO{
    public function listar();
    public function obterPorId(int $id);
    public function inserir(string $nome, string $descricao, float $preco, string $imagem);
    public function alterar(int $id, string $nome, string $descricao, float $preco, string $imagem);
    public function excluir(int $id);
}