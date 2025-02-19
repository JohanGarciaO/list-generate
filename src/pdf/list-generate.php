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
$mpdf = new Mpdf([
    'margin_left' => 10,    // Margem esquerda
    'margin_right' => 10,   // Margem direita
    'margin_top' => 17,     // Margem superior
    'margin_bottom' => 21,  // Margem inferior (para rodapé)
    'margin_header' => 0,  // Margem do cabeçalho
    'margin_footer' => 0   // Margem do rodapé
]);

// Adiciona o cabeçalho em todas as páginas
$mpdf->SetHTMLHeader('
    <div class="header-container">
        <table class="content-header">
            <tr>
                <td class="tittle">Monitoria <span class="emphasis_tittle">Sefianas</span></td>
            </tr>
            <tr>
                <td class="separator-h"></td>
            </tr>
        </table>
    </div>
');

// Adiciona o cabeçalho em todas as páginas
$mpdf->SetHTMLFooter('
    <div class="footer-container">
        <table class="content-footer">
            <tr>
                <td class="info-footer">Larissa Teixeira</td>
                <td class="number-page">1</td>
            </tr>
        </table>
    </div>
');

// Adicionar o HTML processado ao PDF
$mpdf->WriteHTML($template);

// Gera o PDF e envia para o navegador
header('Content-Type: application/pdf');
// header('Content-Disposition: attachment; filename="new-list.pdf"');
echo $mpdf->Output('', 'S'); // Retorna o PDF como string