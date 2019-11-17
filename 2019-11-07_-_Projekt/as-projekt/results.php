<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wyniki Testu</title>
</head>

<body>
    <?php
    include('dbcredentials.php');
    $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

    if ($conn->connect_errno) die('Brak połączenia');

    $rs = $conn->query('SET NAMES utf8')
        or die('Nie udało się ustawić CHARSET');

    $is_old = false;

    $rs = $conn->query('SELECT `timestamp` FROM `results` WHERE `timestamp` = ' . $_POST['exam_end'])
        or die('Błąd pobierania danych 0');

    if ($rs->num_rows != 0) {
        $is_old = true;
    }

    echo '
            <h2> Wyniki Testu
                <form action="/as-projekt/" method="GET">
                    <button>Wróć do strony głównej</button>
                </form>
            </h2>
            ';

    $num_correct = 0;
    $q_num = 1;
    while ($q_num <= 10) {
        $rs = $conn->query('SELECT `qid`, `contents` AS "question" FROM `questions` WHERE `qid` = ' . $_POST['qid_q' . $q_num])
            or die('Błąd pobierania danych 0');

        if ($rs->num_rows > 0) {
            while ($rec = $rs->fetch_array()) {
                echo '<table border=1>
                        <input type="hidden" name="qid_q' . $q_num . '" value="' . $rec['qid'] . '">
                        <tr>
                            <th>' . $q_num . '</th>
                            <th colspan="2">' . $rec['question'] . '</th>
                        </tr>';

                $rs1 = $conn->query('SELECT `aid`, `contents`  AS "answer", `is_correct` FROM `answers` WHERE `qid` = "' . $rec['qid'] . '" ')
                    or die('Błąd pobierania danych 1');

                if ($rs1->num_rows > 0) {
                    $a_num = ord('A');
                    while ($rec1 = $rs1->fetch_array()) {
                        if ($rec1['is_correct']) {
                            if ($rec1['aid'] == $_POST['aid_q' . $q_num]) {
                                echo '
                                    <tr style="color: green">
                                        <td>' . chr($a_num) . '</td>
                                        <td><input type="radio" checked></td>
                                        <td>' . $rec1['answer'] . '</td>
                                    </tr>';

                                if (!$is_old) {
                                    $rs2 = $conn->query('UPDATE `questions` SET `ans_total` = `ans_total` + 1, `ans_correct` = `ans_correct` + 1 WHERE `qid` = ' . $rec['qid'])
                                        or die('Błąd wysyłania');
                                }

                                $num_correct += 1;
                            } else {
                                echo '
                                    <tr style="color: green">
                                        <td>' . chr($a_num) . '</td>
                                        <td><input type="radio"></td>
                                        <td>' . $rec1['answer'] . '</td>
                                    </tr>';
                            }
                        } else if ($rec1['aid'] == $_POST['aid_q' . $q_num]) {
                            echo '
                                <tr style="color: red">
                                    <td>' . chr($a_num) . '</td>
                                    <td><input type="radio" checked></td>
                                    <td>' . $rec1['answer'] . '</td>
                                </tr>';

                            if (!$is_old) {
                                $rs2 = $conn->query('UPDATE `questions` SET `ans_total` = `ans_total` + 1 WHERE `qid` = ' . $rec['qid'])
                                    or die('Błąd wysyłania');
                            }
                        } else {
                            echo '
                                <tr>
                                    <td>' . chr($a_num) . '</td>
                                    <td><input type="radio"></td>
                                    <td>' . $rec1['answer'] . '</td>
                                </tr>';
                        }

                        $a_num += 1;
                    }
                }
                echo '</table>';

                $q_num += 1;
            }
        }
    }

    echo '
        <h2> Twój wynik to: ' . ($num_correct / 10) * 100 .
        '% (' . $num_correct . '/10)
        </h2>
    ';

    $uid = 0;
    $rs = $conn->query('SELECT `uid` FROM `users` WHERE `username` = "' . $_COOKIE['username'] . '" AND `password` = "' . $_COOKIE['password'] . '"')
        or die('Błąd pobierania danych 2');

    if ($rs->num_rows > 0) {
        $rec = $rs->fetch_array();

        $uid = $rec['uid'];

        if (!$is_old) {
            $rs1 = $conn->query('INSERT INTO `results`(`ans_correct`, `uid`, `timestamp`) VALUES ("' . $num_correct . '","' . $uid . '","' . $_POST['exam_end'] . '")')
                or die('Błąd wysyłania danych');
        }
    }

    echo '
        <form action="/as-projekt/" method="GET">
            <button>Wróć do strony głównej</button>
        </form>
    ';
    ?>
</body>

</html>