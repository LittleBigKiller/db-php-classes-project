<?php
    echo '<table style="text-align: center">';
    for ($i = 1; $i <= 5; $i++) {
        echo '<tr>';
        for ($j = 1; $j <= 8; $j++) {
            if ($i == 1 || $j == 1) {
                echo('<td style="padding: 1px 4px"><b>'.($i * $j).'</b></td>');
            } else {
                echo '<td style="padding: 1px 4px">'.($i * $j).'</td>';
            }
        }
        echo '</tr>';
    }
    echo '</table>'
?>