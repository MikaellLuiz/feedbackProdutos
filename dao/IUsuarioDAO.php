<?php

namespace CasasLuiza\dao;

interface IUsuarioDAO{
    public function listar();
    public function obterPorId(int $id);
    public function inserir(string $nome, string $email, string $senha, bool $admin);
    public function alterar(int $id, string $nome, string $email, string $senha, bool $admin);
    public function excluir(int $id);
    public function obterUsuarioPorEmail(string $email);
}