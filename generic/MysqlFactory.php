<?php
namespace CasasLuiza\generic;

/**
 * Classe MysqlFactory
 * 
 * Implementa um padrão Factory para acesso ao banco de dados MySQL
 * Fornece uma instância do singleton de conexão com o banco de dados
 */
class MysqlFactory{
    /**
     * @var MysqlSingleton Instância do singleton de conexão com o banco de dados
     */
    public MysqlSingleton $banco;
    
    /**
     * Construtor da classe MysqlFactory
     * 
     * Inicializa a conexão com o banco de dados MySQL
     */
    public function __construct()
    {
        $this->banco=MysqlSingleton::getInstance();
    }
}