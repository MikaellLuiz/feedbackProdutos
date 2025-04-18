<?php
include "generic/Autoloader.php";

use CasasLuiza\generic\Controller;
use CasasLuiza\generic\DotEnv;

// Carrega as variáveis de ambiente
(new DotEnv(__DIR__ . '/.env'))->load();

// Captura a URL diretamente
$requestUri = $_SERVER['REQUEST_URI'];
$baseDir = dirname($_SERVER['SCRIPT_NAME']);

// Remove o diretório base da URI
if ($baseDir !== '/' && strpos($requestUri, $baseDir) === 0) {
    $requestUri = substr($requestUri, strlen($baseDir));
}

// Remove query strings se existirem
$requestUri = explode('?', $requestUri)[0];

// Remove barra inicial se existir
$rota = ltrim($requestUri, '/');

$controller = new Controller();
$controller->verificarChamadas($rota);
