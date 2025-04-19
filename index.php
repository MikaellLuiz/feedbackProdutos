<?php
/**
 * Ponto de entrada principal da aplicação
 * 
 * Responsável por inicializar o sistema, carregar variáveis de ambiente,
 * processar a rota solicitada e encaminhar para o controlador apropriado
 * 
 * @package CasasLuiza
 */

include "generic/Autoloader.php";

use CasasLuiza\generic\Controller;
use CasasLuiza\generic\DotEnv;

(new DotEnv(__DIR__ . '/.env'))->load();

$requestUri = $_SERVER['REQUEST_URI'];
$baseDir = dirname($_SERVER['SCRIPT_NAME']);

if ($baseDir !== '/' && strpos($requestUri, $baseDir) === 0) {
    $requestUri = substr($requestUri, strlen($baseDir));
}

$requestUri = explode('?', $requestUri)[0];
$rota = ltrim($requestUri, '/');

// Inicializa o controlador principal e processa a rota solicitada
$controller = new Controller();
$controller->verificarChamadas($rota);
