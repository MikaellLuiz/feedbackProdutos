<?php
namespace CasasLuiza\service;

use CasasLuiza\dao\mysql\UsuarioDAO;

class UsuarioService extends UsuarioDAO {
    public function listarUsuarios() {
        return parent::listar();
    }

    public function obterUsuarioPorId(int $id) {
        return parent::obterPorId($id);
    }

    public function inserirUsuario(string $nome, string $email, string $senha, bool $admin) {
        return parent::inserir($nome, $email, $senha, $admin);
    }

    public function alterarUsuario(int $id, string $nome, string $email, string $senha, bool $admin) {
        return parent::alterar($id, $nome, $email, $senha, $admin);
    }

    public function excluirUsuario(int $id) {
        return parent::excluir($id);
    }
}