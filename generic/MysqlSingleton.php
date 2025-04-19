<?php
namespace CasasLuiza\generic;

use PDO;

/**
 * Classe MysqlSingleton
 * 
 * Implementa o padrão Singleton para conexão com o banco de dados MySQL
 * Garante uma única instância de conexão durante a execução da aplicação
 */
class MysqlSingleton{
    /**
     * @var MysqlSingleton|null Instância única da classe
     */
    private static $instance = null;

    /**
     * @var PDO|null Conexão com o banco de dados
     */
    private $conexao = null;
    
    /**
     * @var string DSN de conexão com o banco de dados
     */
    private $dsn;
    
    /**
     * @var string Usuário do banco de dados
     */
    private $usuario;
    
    /**
     * @var string Senha do banco de dados
     */
    private $senha;

    /**
     * Construtor da classe MysqlSingleton
     * 
     * Inicializa a conexão com o banco de dados MySQL utilizando variáveis de ambiente
     */
    private function __construct(){
        // Carrega as variáveis de ambiente se ainda não estiverem definidas
        if (!isset($_ENV['DB_HOST'])) {
            (new DotEnv(__DIR__ . '/../.env'))->load();
        }
        
        $host = getenv('DB_HOST') ?: 'localhost';
        $dbname = getenv('DB_NAME') ?: 'feedback_produtos';
        $this->usuario = getenv('DB_USER') ?: 'root';
        $this->senha = getenv('DB_PASSWORD') ?: '';
        $this->dsn = "mysql:host={$host};dbname={$dbname}";
        
        if($this->conexao == null){
            $this->conexao = new PDO($this->dsn, $this->usuario, $this->senha);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    /**
     * Retorna a instância única da classe
     * 
     * @return MysqlSingleton Instância única da classe
     */
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new MysqlSingleton();
        }

        return self::$instance;
    }

    /**
     * Executa uma consulta SQL no banco de dados
     * 
     * @param string $query Consulta SQL a ser executada
     * @param array $param Parâmetros para a consulta
     * @return array Resultado da consulta em formato associativo
     */
    public function executar($query,$param = array()){
        if($this->conexao){
            $sth = $this->conexao->prepare($query);
            foreach($param as $k => $v){
                $sth->bindValue($k,$v);
            }
            
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}