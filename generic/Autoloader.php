<?php
/**
 * Autoloader
 * 
 * Configuração do autoload para carregar classes automaticamente
 * utilizando PSR-4 para o namespace CasasLuiza
 * 
 * @package CasasLuiza
 */

spl_autoload_register(function(string $className){
    $namespace = "CasasLuiza\\";
    
    if (strpos($className, $namespace) === 0) {
        $relativeClass = substr($className, strlen($namespace));
        
        $file = __DIR__ . '/../' . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        }
    }
});