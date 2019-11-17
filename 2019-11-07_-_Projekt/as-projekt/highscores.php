<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>10 najlepszych użytkowników</title>
</head>

<body>
    <?php
    include('dbcredentials.php');
    $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

    if ($conn->connect_errno) die('Brak połączenia');

    $rs = $conn->query('SET NAMES utf8')
        or die('Nie udało się ustawić CHARSET');

    echo '
        <h2> 10 najlepszych użytkowników
            <form action="/as-projekt/" method="GET">
                <button>Wróć do strony głównej</button>
            </form>
        </h2>
        ';

    $rs = $conn->query('SELECT `users`.`username` AS "username", AVG(`results`.`ans_correct`) AS "avg" FROM `results` INNER JOIN `users` ON `results`.`uid` = `users`.`uid` GROUP BY `results`.`uid` ORDER BY AVG(`results`.`ans_correct`) DESC LIMIT 10')
        or die('Błąd pobierania danych 2');


    echo '<table border=1>
        <tr><th>Użytkownik</th><th>Średnia Ocen</th></tr>';

    if ($rs->num_rows > 0) {
        while ($rec = $rs->fetch_array()) {
            echo '
                <tr>
                    <td>' . $rec['username'] . '</td>
                    <td>' . ($rec['avg'] * 10) . '%</td>
                </tr>';
        }
    } else {
        echo '
            <tr>
                <td colspan="2">Brak Danych</td>
            </tr>';
    }

    echo '</table>';
    ?>
</body>

</html>