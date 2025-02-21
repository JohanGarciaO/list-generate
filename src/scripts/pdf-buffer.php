<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Mpdf\Mpdf;

function size($template_buffer)
{
    $size_elements = new Mpdf([
        'margin_left' => 10,    // Margem esquerda
        'margin_right' => 10,   // Margem direita
        'margin_top' => 17,     // Margem superior
        'margin_bottom' => 21,  // Margem inferior (para rodapé)
        'margin_header' => 0,  // Margem do cabeçalho
        'margin_footer' => 0   // Margem do rodapé
    ]);

    // Adiciona o cabeçalho em todas as páginas
    $size_elements->SetHTMLHeader('
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
    $size_elements->SetHTMLFooter('
        <div class="footer-container">
            <table class="content-footer">
                <tr>
                    <td class="info-footer">Larissa Teixeira</td>
                    <td class="number-page">1</td>
                </tr>
            </table>
        </div>
    ');

    $size_elements->WriteHTML($template_buffer);

    $last_position = $size_elements->y;
    return $last_position;
}
