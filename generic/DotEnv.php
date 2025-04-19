<?php
namespace CasasLuiza\generic;

/**
 * Classe DotEnv
 * 
 * Implementa um carregador de variáveis de ambiente a partir de um arquivo .env
 * Permite configurar a aplicação sem expor informações sensíveis no código-fonte
 */
class DotEnv
{
    /**
     * @var string Caminho para o arquivo .env
     */
    protected $path;

    /**
     * Construtor da classe DotEnv
     * 
     * @param string $path Caminho para o arquivo .env
     * @throws \InvalidArgumentException Se o arquivo não existir
     */
    public function __construct(string $path)
    {
        if(!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s não existe', $path));
        }
        $this->path = $path;
    }

    /**
     * Carrega as variáveis de ambiente do arquivo .env
     * 
     * @throws \RuntimeException Se o arquivo não for legível
     * @return void
     */
    public function load() : void
    {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s não é legível', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            // Remove aspas se existirem
            if (strpos($value, '"') === 0 || strpos($value, "'") === 0) {
                $value = substr($value, 1, -1);
            }

            if (!array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}