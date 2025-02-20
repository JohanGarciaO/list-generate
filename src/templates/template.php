<!DOCTYPE html>
<html>

<head>
    <title>Lista Tal</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT'] . "/src/templates/template-style.css" ?>">
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

    <!-- <div class="subject-list">
        <b>Clínica Médica e Farmacologia</b>
    </div> -->

    <div class="container">
        <div class="left-column">
            <?php 

            for($i=1;$i<=24;$i++){
                echo "<p>$i. Teste</p>";
            }

            ?>
        </div>
        
        <div class="right-column">
            <?php 

            for($i=1;$i<=24;$i++){
                echo "<p>$i. Teste</p>";
            }
            
            ?>
        </div>

        <div class="left-column">
            <?php 

            for($i=1;$i<=24;$i++){
                echo "<p>$i. Teste</p>";
            }

            ?>
        </div>
        
        <div class="right-column">
            <?php 

            for($i=1;$i<=24;$i++){
                echo "<p>$i. Teste</p>";
            }
            
            ?>
        </div>
    </div>
    
</body>

</html>