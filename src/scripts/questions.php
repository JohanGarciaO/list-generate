<?php

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
