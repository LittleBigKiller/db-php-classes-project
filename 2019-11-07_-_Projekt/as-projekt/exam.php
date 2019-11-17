<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test 10 Pytań</title>
</head>

<body>
    <?php
    include('dbcredentials.php');
    $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

    if ($conn->connect_errno) die('Brak połączenia');

    $rs = $conn->query('SET NAMES utf8')
        or die('Nie udało się ustawić CHARSET');

    echo '
            <h2> Test 10 Pytań
                <form action="/as-projekt/" method="GET">
                    <button>Wróć do strony głównej</button>
                </form>
            </h2>
            ';

    $rs = $conn->query('SELECT `qid`, `contents` AS "question" FROM `questions` ORDER BY RAND() LIMIT 10')
        or die('Błąd pobierania danych 0');

    echo '
        <form action="/as-projekt/results.php" method="POST">
    ';

    if ($rs->num_rows > 0) {
        $q_num = 1;
        while ($rec = $rs->fetch_array()) {
            echo '<table border=1>
                    <input type="hidden" name="qid_q' . $q_num . '" value="' . $rec['qid'] . '">
                    <tr>
                        <th>' . $q_num . '</th>
                        <th colspan="2">' . $rec['question'] . '</th>
                    </tr>';

            $rs1 = $conn->query('SELECT `aid`, `contents` AS "answer" FROM `answers` WHERE `qid` = "' . $rec['qid'] . '" ')
                or die('Błąd pobierania danych 1');

            if ($rs1->num_rows > 0) {
                $a_num = ord('A');
                while ($rec1 = $rs1->fetch_array()) {
                    echo '
                        <tr>
                            <td>' . chr($a_num) . '</td>
                            <td><input type="radio" name="aid_q' . $q_num . '" value="' . $rec1['aid'] . '"></td>
                            <td>' . $rec1['answer'] . '</td>
                        </tr>';

                    $a_num += 1;
                }
            }
            echo '</table>';

            $q_num += 1;
        }
    }

    echo '
        <button name="exam_end" value="' . time() . '">Zakończ podejście</button>
        </form>
    ';
    ?>
</body>

</html>