<?php
namespace CasasLuiza\generic;

use PDO;

class MysqlSingleton{
    private static $instance = null;

    private $conexao = null;
    private $dsn;
    private $usuario;
    private $senha;

    private function __construct(){
        // Carrega as variáveis de ambiente se ainda não estiverem definidas
        if (!isset($_ENV['DB_HOST'])) {
            (new DotEnv(__DIR__ . '/../.env'))->load();
        }
        
        // Utiliza as variáveis de ambiente para a conexão com o banco
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

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new MysqlSingleton();
        }

        return self::$instance;
    }

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