<?php
include "generic/Autoloader.php";

use CasasLuiza\generic\Controller;
use CasasLuiza\generic\DotEnv;

// Carrega as variáveis de ambiente
(new DotEnv(__DIR__ . '/.env'))->load();

$rota = isset($_GET["rota"]) ? $_GET["rota"] : "";
$controller = new Controller();
$controller->verificarChamadas($rota);
