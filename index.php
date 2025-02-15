<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Mpdf\Mpdf;

// Carrega as variáveis de ambiente do arquivo .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Obtém variáveis do .env
$appName = $_ENV['APP_NAME'] ?? 'Desconhecido';
$appVersion = $_ENV['APP_VERSION'] ?? '0.0';

// Cria um arquivo PDF
$mpdf = new Mpdf();
$mpdf->WriteHTML("<h1>$appName</h1><p>Versão: $appVersion</p>");
$mpdf->Output('arquivo.pdf', 'I'); // Exibe o PDF no navegador
