<?php
namespace CasasLuiza\service;

use CasasLuiza\dao\mysql\UsuarioDAO;

/**
 * Classe UsuarioService
 * 
 * Implementa os serviços relacionados aos usuários
 * Estende a classe UsuarioDAO para acesso direto às operações de banco de dados
 * 
 * @package CasasLuiza\service
 */
class UsuarioService extends UsuarioDAO {
    /**
     * Lista todos os usuários não excluídos do sistema
     * 
     * @return array Lista de usuários
     */
    public function listarUsuarios() {
        return parent::listar();
    }

    /**
     * Obtém um usuário específico pelo ID
     * 
     * @param int $id ID do usuário a ser obtido
     * @return array Dados do usuário
     */
    public function obterUsuarioPorId(int $id) {
        return parent::obterPorId($id);
    }

    /**
     * Insere um novo usuário no sistema
     * 
     * @param string $nome Nome do usuário
     * @param string $email Email do usuário
     * @param string $senha Senha do usuário (será criptografada)
     * @param bool $admin Define se o usuário é administrador
     * @return array Resultado da operação
     */
    public function inserirUsuario(string $nome, string $email, string $senha, bool $admin) {
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
        return parent::inserir($nome, $email, $senhaCriptografada, $admin);
    }

    /**
     * Altera os dados de um usuário existente
     * 
     * @param int $id ID do usuário a ser alterado
     * @param string $nome Novo nome do usuário
     * @param string $email Novo email do usuário
     * @param string $senha Nova senha do usuário (opcional)
     * @param bool $admin Define se o usuário é administrador
     * @return array|bool Resultado da operação
     */
    public function alterarUsuario(int $id, string $nome, string $email, string $senha, bool $admin) {
        if (!empty($senha)) {
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
            return parent::alterar($id, $nome, $email, $senhaCriptografada, $admin);
        } else {
            $usuario = $this->obterUsuarioPorId($id);
            if ($usuario && isset($usuario[0]['senha'])) {
                return parent::alterar($id, $nome, $email, $usuario[0]['senha'], $admin);
            }
            return false;
        }
    }

    /**
     * Exclui logicamente um usuário do sistema
     * 
     * @param int $id ID do usuário a ser excluído
     * @return array Resultado da operação
     */
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
     * @param string $email Email do usuário
     * @param string $senha Senha do usuário (não criptografada)
     * @return array|bool Dados do usuário se autenticado, ou false se falhou
     */
    public function autenticarUsuario(string $email, string $senha) {
        $usuario = $this->obterPorEmail($email);
        
        if (!empty($usuario) && isset($usuario[0]['senha'])) {
            if (password_verify($senha, $usuario[0]['senha'])) {
                return $usuario[0];
            }
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
        
        return !empty($usuarios) && $usuarios[0]['id'] != $usuarioId;
    }
}