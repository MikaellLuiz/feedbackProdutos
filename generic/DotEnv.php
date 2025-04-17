<?php
namespace CasasLuiza\generic;

class DotEnv
{
    protected $path;

    public function __construct(string $path)
    {
        if(!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s não existe', $path));
        }
        $this->path = $path;
    }

    public function load() : void
    {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s não é legível', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Ignora comentários
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