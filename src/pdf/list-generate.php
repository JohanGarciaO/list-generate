<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Dotenv\Dotenv;
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

// Carrega as variáveis de ambiente do arquivo .env
$dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

// Obtém variáveis do .env
$appName = $_ENV['APP_NAME'] ?? 'Desconhecido';
$appVersion = $_ENV['APP_VERSION'] ?? '0.0';

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
                <td class="number-page">{PAGENO}</td>
            </tr>
        </table>
    </div>
');

$src_style = $_SERVER['DOCUMENT_ROOT'] . "/src/templates/template-style.css";

$template = '
<!DOCTYPE html>
<html>

<head>
    <title>Lista Tal</title>
    <link rel="stylesheet" type="text/css" href="' . $src_style . '">
</head>

<body>

    <div class="info-header">
        <table class="content-header">
            <tr>
                <td class="gap-fields">Início: ______:______</td>
                <td class="gap-fields">Término: ______:______</td>
                <td class="gap-fields">Acertos: _______</td>
                <td class="gap-fields">Erros: _______</td>
                <td class="gap-fields">Data: _____ /_____ /_______</td>
            </tr>
        </table>
    </div>

    <div class="container">
        <div class="left-column">
            <div class="subject-list">
                <b>Clínica Médica e Farmacologia</b>
            </div>
';

$template_null = $template;
$template_buffer = $template_null;

$column = 'left';
$last_size = 0;

// Objective Question
function objective_question($number_question, $statement, $json_alternatives)
{
    $alternatives = json_decode($json_alternatives, true);

    if ($alternatives === null) {
        die("Erro ao decodificar JSON: " . json_last_error_msg());
    }

    $question = '
    <div class="question">
        <p><b>' . $number_question . '</b> - ' . $statement . '</p>';

    $question .= '<div class="options">';
    foreach ($alternatives as $key => $value) {
        $question .= "<span>$key) $value</span><br>";
    }
    $question .= '
        </div>
    </div>';

    return $question;
}

// Gap Question 
function gap_question($number_question, $statement, $gap_context, $json_alternatives)
{
    $alternatives = json_decode($json_alternatives, true);

    if ($alternatives === null) {
        die("Erro ao decodificar JSON: " . json_last_error_msg());
    }

    $question = '
    <div class="question">
        <p><b>' . $number_question . '</b> - ' . $statement . '</p>

        <p>' . $gap_context . '</p>';

    $question .= '<div class="options">';
    foreach ($alternatives as $key => $value) {
        $question .= "<span>$key) $value</span><br>";
    }
    $question .= '
        </div>
    </div>';

    return $question;
}

// Assertive Question 
function asssertive_question($number_question, $statement, $json_assertions, $json_alternatives)
{
    $alternatives = json_decode($json_alternatives, true);
    $assertions = json_decode($json_assertions, true);

    if ($alternatives === null || $assertions === null) {
        die("Erro ao decodificar JSON: " . json_last_error_msg());
    }

    $question = '
    <div class="question">
        <p><b>' . $number_question . '</b> - ' . $statement . '</p>';

    $question .= '<p>';
    foreach ($assertions as $key => $value) {
        $question .= "<span>$key. $value</span><br>";
    }
    $question .= '</p>';

    $question .= '<div class="options">';
    foreach ($alternatives as $key => $value) {
        $question .= "<span>$key) $value</span><br>";
    }
    $question .= '
        </div>
    </div>';

    return $question;
}

// Correlate Question 
function correlate_question($number_question, $statement, $json_correlations, $json_alternatives)
{
    $alternatives = json_decode($json_alternatives, true);
    $correlations = json_decode($json_correlations, true);

    if ($alternatives === null || $correlations === null) {
        die("Erro ao decodificar JSON: " . json_last_error_msg());
    }

    $question = '
    <div class="question">
        <p><b>' . $number_question . '</b> - ' . $statement . '</p>';

    $question .= '<p>';
    foreach ($correlations['assertive'] as $key => $value) {
        $question .= "<span>$key. $value</span><br>";
    }
    $question .= '</p>';

    $question .= '<p>';
    foreach ($correlations['related'] as $value) {
        $question .= "<span>( ) $value</span><br>";
    }
    $question .= '</p>';

    $question .= '<div class="options">';
    foreach ($alternatives as $key => $value) {
        $question .= "<span>$key) $value</span><br>";
    }
    $question .= '
        </div>
    </div>';

    return $question;
}

$objective_statement = "Este é um texto aleatório para testar a estrutura de uma questão, ver aí se deu certo e me confirma:";

$objective_json_alternatives = '{
"a": "Deu certo.", 
"b": "Não deu.", 
"c": "Acho que deu.",
"d": "Não deu mas vai dar."
}';

$gap_statement = "Complete as lacunas abaixo e selecione a alternativa correta:";

$gap_context = "A(O) __________ é muito __________ e por isso a Larissa não toma banho.";

$gap_json_alternatives = '{
"a": "Terra - querosene.", 
"b": "Querosene - forte.", 
"c": "Suco - quente.",
"d": "Água - gelada."
}';

$assertive_statement = "Complete as lacunas abaixo e selecione a alternativa correta:";

$assertions = '{
    "I": "Essa é a assertiva 1.", 
    "II": "Essa é a assertiva 2.", 
    "III": "Essa é a assertiva 3.",
    "IV": "Essa é a assertiva 4."
    }';

$assertive_json_alternatives = '{
"a": "I, II e IV.", 
"b": "Apenas a I.", 
"c": "I e IV.",
"d": "Apenas a III."
}';

$correlate_statement = "Complete as lacunas abaixo e selecione a alternativa correta:";

$correlations = '{
    "assertive": {
        "1": "Planeta mais próximo do Sol",
        "2": "Maior planeta do Sistema Solar",
        "3": "Único planeta com vida conhecida",
        "4": "Planeta conhecido como \'Planeta Vermelho\'"
    },
    "related": {
        "1": "Júpiter",
        "2": "Terra",
        "3": "Marte",
        "4": "Mercúrio"
    }
}';

$correlate_json_alternatives = '{
"a": "1-2-3-4.", 
"b": "1-3-2-4.", 
"c": "2-1-4-3.",
"d": "2-1-3-4."
}';

for ($i = 1; $i <= 10; $i++) {

    if ($i % 2 == 0) {
        if ($i % 4 == 0) {
            $item = correlate_question($i, $correlate_statement, $correlations, $correlate_json_alternatives);
        } else {
            $item = gap_question($i, $gap_statement, $gap_context, $gap_json_alternatives);
        }
    } else {
        if ($i % 3 == 0) {
            $item = asssertive_question($i, $assertive_statement, $assertions, $assertive_json_alternatives);
        } else {
            $item = objective_question($i, $objective_statement, $objective_json_alternatives);
        }
    }

    // Se o novo tamanho for menor do que o tamanho antigo é porque haverá quebra de página, então joga o item pra próxima coluna
    $post_size = size($template_buffer . $item);
    if ($post_size < $last_size) {
        if ($column == 'left') {
            $column = 'right';
            $template .= '</div>';
            $template .= '<div class="right-column">';
        } else {
            $column = 'left';
            $template .= '</div>';
            $template .= '<div class="left-column">';
        }
        $template_buffer = $template_null;
        $last_size = 0;
    }

    $template .= $item;
    $template_buffer .= $item;
    $last_size = $post_size;
}

$template .= '</div>';

$mpdf->WriteHTML($template);

$template = '
</div>
</body>
</html>
';
$mpdf->WriteHTML($template);

// Gera o PDF e envia para o navegador
header('Content-Type: application/pdf');
// header('Content-Disposition: attachment; filename="new-list.pdf"');
echo $mpdf->Output('', 'S'); // Retorna o PDF como string