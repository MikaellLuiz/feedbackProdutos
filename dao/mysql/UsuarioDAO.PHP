<?php
namespace CasasLuiza\dao\mysql;

use CasasLuiza\dao\IUsuarioDAO;
use CasasLuiza\generic\MysqlFactory;

class UsuarioDAO extends MysqlFactory implements IUsuarioDAO{
    public function listar(){
        $sql = "SELECT id, nome, email, admin FROM usuarios WHERE deleted = FALSE";
        return $this->banco->executar($sql);
    }
    
    public function obterPorId(int $id){
        $sql = "SELECT id, nome, email, senha, admin
                FROM usuarios
                WHERE id = :id AND deleted = FALSE";

        $param = [
            ":id" => $id
        ];
        
        return $this->banco->executar($sql, $param);
    }
    
    public function inserir(string $nome, string $email, string $senha, bool $admin){
        $sql = "INSERT INTO usuarios (nome, email, senha, admin) 
                VALUES (:nome, :email, :senha, :admin)";

        $param = [
            ":nome" => $nome,
            ":email" => $email,
            ":senha" => $senha,
            ":admin" => $admin ? 1 : 0
        ];

        return $this->banco->executar($sql, $param);
    }

    public function alterar(int $id, string $nome, string $email, string $senha, bool $admin){
        $sql = "UPDATE usuarios 
                SET nome = :nome, 
                    email = :email, 
                    senha = :senha, 
                    admin = :admin 
                WHERE id = :id";

        $param = [
            ":id" => $id,
            ":nome" => $nome,
            ":email" => $email,
            ":senha" => $senha,
            ":admin" => $admin ? 1 : 0
        ];

        return $this->banco->executar($sql, $param);
    }

    public function excluir(int $id){
        $sql = "UPDATE usuarios SET deleted = TRUE WHERE id = :id";

        $param = [
            ":id" => $id
        ];

        return $this->banco->executar($sql, $param);
    }
    
    /**
     * Obtém um usuário pelo e-mail
     * 
     * @param string $email O e-mail do usuário
     * @return array Dados do usuário
     */
    public function obterUsuarioPorEmail(string $email){
        $sql = "SELECT id, nome, email, senha, admin
                FROM usuarios
                WHERE email = :email AND deleted = FALSE";

        $param = [
            ":email" => $email
        ];
        
        return $this->banco->executar($sql, $param);
    }
}

