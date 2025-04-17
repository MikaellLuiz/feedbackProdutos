<?php

spl_autoload_register(function(string $className){
    $namespace = "CasasLuiza\\";
    
    if (strpos($className, $namespace) === 0) {
        // Remove o namespace base
        $relativeClass = substr($className, strlen($namespace));
        
        // Converte barras de namespace para separadores de diretório
        $file = __DIR__ . '/../' . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        }
    }
});