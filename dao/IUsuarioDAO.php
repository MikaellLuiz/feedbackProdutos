<?php

namespace CasasLuiza\dao;

/**
 * Interface IUsuarioDAO
 * Define os métodos para operações de usuário no banco de dados
 */
interface IUsuarioDAO{
    /**
     * Lista todos os usuários cadastrados
     * 
     * @return array Lista de todos os usuários
     */
    public function listar();
    
    /**
     * Obtém um usuário pelo ID
     * 
     * @param int $id ID do usuário
     * @return array Dados do usuário
     */
    public function obterPorId(int $id);
    
    /**
     * Insere um novo usuário no banco de dados
     * 
     * @param string $nome Nome do usuário
     * @param string $email Email do usuário
     * @param string $senha Senha do usuário
     * @param bool $admin Indica se o usuário é administrador
     * @return mixed Resultado da inserção
     */
    public function inserir(string $nome, string $email, string $senha, bool $admin);
    
    /**
     * Altera um usuário existente
     * 
     * @param int $id ID do usuário
     * @param string $nome Nome do usuário
     * @param string $email Email do usuário
     * @param string $senha Senha do usuário
     * @param bool $admin Indica se o usuário é administrador
     * @return mixed Resultado da alteração
     */
    public function alterar(int $id, string $nome, string $email, string $senha, bool $admin);
    
    /**
     * Exclui um usuário do banco de dados
     * 
     * @param int $id ID do usuário
     * @return mixed Resultado da exclusão
     */
    public function excluir(int $id);
    
    /**
     * Obtém um usuário pelo email
     * 
     * @param string $email Email do usuário
     * @return array Dados do usuário
     */
    public function obterUsuarioPorEmail(string $email);
}