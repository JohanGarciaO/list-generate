<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Mpdf\Mpdf;

// Carrega as variáveis de ambiente do arquivo .env
$dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

// Obtém variáveis do .env
$appName = $_ENV['APP_NAME'] ?? 'Desconhecido';
$appVersion = $_ENV['APP_VERSION'] ?? '0.0';

// Iniciar buffer de saída para capturar o HTML processado
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/src/templates/template.php';
$template = ob_get_clean();

// Cria um arquivo PDF
$mpdf = new Mpdf();

// Adiciona a marca d'água no cabeçalho de todas as páginas
$mpdf->SetHTMLHeader('
    <div class="watermark">
        <img src="../images/watermark.png">
    </div>
');

// Adicionar o HTML processado ao PDF
$mpdf->WriteHTML($template);

// Gera o PDF e envia para o navegador
header('Content-Type: application/pdf');
// header('Content-Disposition: attachment; filename="new-list.pdf"');
echo $mpdf->Output('', 'S'); // Retorna o PDF como string