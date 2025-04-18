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
        // Criptografa a senha antes de salvar
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
        return parent::inserir($nome, $email, $senhaCriptografada, $admin);
    }

    public function alterarUsuario(int $id, string $nome, string $email, string $senha, bool $admin) {
        // Se a senha foi fornecida, criptografa antes de salvar
        if (!empty($senha)) {
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
            return parent::alterar($id, $nome, $email, $senhaCriptografada, $admin);
        } else {
            // Busca o usuário atual para manter a senha existente
            $usuario = $this->obterUsuarioPorId($id);
            if ($usuario && isset($usuario[0]['senha'])) {
                return parent::alterar($id, $nome, $email, $usuario[0]['senha'], $admin);
            }
            return false;
        }
    }

    public function excluirUsuario(int $id) {
        return parent::excluir($id);
    }
    
    /**
     * Verifica se um e-mail já existe no banco de dados
     * 
     * @param string $email O e-mail a ser verificado
     * @return bool True se o e-mail existe, False caso contrário
     */
    public function emailExiste(string $email) {
        $result = $this->obterPorEmail($email);
        return !empty($result);
    }
    
    /**
     * Autentica um usuário pelo e-mail e senha
     * 
     * @param string $email O e-mail do usuário
     * @param string $senha A senha do usuário
     * @return array|bool Dados do usuário se autenticado com sucesso, False caso contrário
     */
    public function autenticarUsuario(string $email, string $senha) {
        $usuario = $this->obterPorEmail($email);
        
        if (empty($usuario)) {
            return false;
        }
        
        // Verifica se a senha fornecida corresponde à senha no banco de dados
        if (password_verify($senha, $usuario[0]['senha'])) {
            return $usuario[0];
        }
        
        return false;
    }
    
    /**
     * Obtém um usuário pelo e-mail
     * 
     * @param string $email O e-mail do usuário
     * @return array Dados do usuário
     */
    public function obterPorEmail(string $email) {
        return parent::obterUsuarioPorEmail($email);
    }

    /**
     * Verifica se o e-mail já existe para outro usuário (não para o usuário atual)
     * Útil para verificar se um e-mail está disponível durante a edição de um usuário
     *
     * @param string $email E-mail a verificar
     * @param int $usuarioId ID do usuário atual (para exclusão da verificação)
     * @return bool True se o e-mail já existe para outro usuário, False caso contrário
     */
    public function emailExisteOutroUsuario(string $email, int $usuarioId) {
        $usuarios = parent::obterUsuarioPorEmail($email);
        
        // Só retorna true se encontrou algum usuário com este email E o ID é diferente
        return !empty($usuarios) && $usuarios[0]['id'] != $usuarioId;
    }
}