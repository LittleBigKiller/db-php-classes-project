<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>10 najtrudniejszych pytań</title>
</head>

<body>
    <?php
    include('dbcredentials.php');
    $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

    if ($conn->connect_errno) die('Brak połączenia');

    $rs = $conn->query('SET NAMES utf8')
        or die('Nie udało się ustawić CHARSET');

    echo '
        <h2> 10 najtrudniejszych pytań
            <form action="/as-projekt/" method="GET">
                <button>Wróć do strony głównej</button>
            </form>
        </h2>
        ';

    $rs = $conn->query('SELECT `qid`, `contents` AS "question", `ans_correct` AS "correct", (`ans_total` - `ans_correct`) AS "incorrect", `ans_total` AS "total" FROM `questions` HAVING `ans_total` > 0 ORDER BY `ans_correct` / `ans_total` ASC LIMIT 10')
        or die('Błąd pobierania danych 5');


    echo '<table border=1>
        <tr>
            <th>Pytanie</th>
            <th>Ilość odpowiedzi</th>
            <th>Procent Poprawnych</th>
        </tr>';

    if ($rs->num_rows > 0) {
        while ($rec = $rs->fetch_array()) {
            if ($rec['total'] != 0) {
                echo '
                    <tr>
                        <td>' . $rec['question'] . '</td>
                        <td>' . $rec['total'] . '</td>
                        <td>' . ($rec['total'] != 0 ? $rec['correct'] / $rec['total'] * 100 : '0') . '%</td>
                    </tr>';
            }
        }
    } else {
        echo '
            <tr>
                <td colspan="3">Brak Danych</td>
            </tr>';
    }

    echo '</table>';
    ?>
</body>

</html>