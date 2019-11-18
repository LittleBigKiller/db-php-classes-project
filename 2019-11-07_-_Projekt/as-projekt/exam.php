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

    $rs = $conn->query('SELECT `questions`.`qid`, `questions`.`contents` AS "question" FROM `questions` LEFT JOIN `answers` ON `questions`.`qid` = `answers`.`qid`
        GROUP BY `questions`.`qid`HAVING COUNT(`answers`.`aid`) = 4 AND SUM(`answers`.`is_correct`) = 1 ORDER BY RAND() LIMIT 10 ')
        or die('Błąd pobierania danych 0');

    echo '
        <form action="/as-projekt/results.php" method="POST">
    ';

    if ($rs->num_rows > 0) {
        $q_num = 1;
        while ($rec = $rs->fetch_array()) {
            $question = $rec['question'];
            $question = str_replace('&', '&amp;', $question);
            $question = str_replace('<', '&lt;', $question);
            $question = str_replace('>', '&gt;', $question);
            $question = str_replace('"', '&quot;', $question);
            $question = str_replace('\'', '&#39;', $question);

            echo '<table border=1>
                    <input type="hidden" name="qid_q' . $q_num . '" value="' . $rec['qid'] . '">
                    <tr>
                        <th>' . $q_num . '</th>
                        <th colspan="2">' . $question . '</th>
                    </tr>';

            $rs1 = $conn->query('SELECT `aid`, `contents` AS "answer" FROM `answers` WHERE `qid` = "' . $rec['qid'] . '" ')
                or die('Błąd pobierania danych 1');

            if ($rs1->num_rows > 0) {
                $a_num = ord('A');
                while ($rec1 = $rs1->fetch_array()) {
                    $answer = $rec1['answer'];
                    $answer = str_replace('&', '&amp;', $answer);
                    $answer = str_replace('<', '&lt;', $answer);
                    $answer = str_replace('>', '&gt;', $answer);
                    $answer = str_replace('"', '&quot;', $answer);
                    $answer = str_replace('\'', '&#39;', $answer);

                    echo '
                        <tr>
                            <td>' . chr($a_num) . '</td>
                            <td><input type="radio" name="aid_q' . $q_num . '" value="' . $rec1['aid'] . '"></td>
                            <td>' . $answer . '</td>
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