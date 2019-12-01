<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wyniki Testu</title>

    <link rel="stylesheet" href="style.css">

    <?php
    if (!$passlogin and !isset($_COOKIE['username'])) {
        ?>
        <meta http-equiv="refresh" content="0; url=/as-projekt/" />
    <?php
    }
    ?>
</head>

<body>
    <?php
    $is_loggedin = false;
    if (isset($_COOKIE['username']) and isset($_COOKIE['password']) and !isset($_POST['logout'])) {
        $is_loggedin = true;
    }

    include('dbcredentials.php');
    $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

    if ($conn->connect_errno) die('Brak połączenia');

    $rs = $conn->query('SET NAMES utf8')
        or die('Nie udało się ustawić CHARSET');
    ?>
    <div id="header">
        <div id="header_helper"></div>
        <h1> Wyniki testu </h1>
        <div id="header_helper"></div>
        <div id="loggedin_box">
            <?php
            if ($is_loggedin) {
                $rs = $conn->query('SELECT `perm_level` FROM `users` WHERE `username` = "' . $_COOKIE['username'] . '" AND `password` = "' . $_COOKIE['password'] . '"')
                    or die('Błąd pobierania danych');

                $rec = $rs->fetch_array();

                $is_admin = false;
                if ($rec['perm_level'] == '1') {
                    $is_admin = true;
                }
                ?>
                <div id="loggedin_text">
                    <?php
                        echo 'Zalogowany jako: <b>' . str_replace('\\"', '"', $_COOKIE['username']) . '</b>';
                        ?>
                </div>
                <form action="/as-projekt/" method="POST">
                    <input type="hidden" name="logout" value="true">
                    <button id="loggedin_logout">Wyloguj</button>
                </form>
            <?php
            } else {
                echo '
                    <b>Nie jesteś zalogowany!</b>';
            }
            ?>
        </div>
    </div>
    <div id="main_box">
        <div id="scroll_content_box">
            <?php
            if ($is_loggedin) {
                $is_old = false;

                $rs = $conn->query('SELECT `timestamp` FROM `results` WHERE `timestamp` = ' . $_POST['exam_end'])
                    or die('Błąd pobierania danych 0');

                if ($rs->num_rows != 0) {
                    $is_old = true;
                }

                echo '
                <form  style="order: 2;" action="/as-projekt/" method="GET">
                    <button class="button_menu">Wróć do strony głównej</button>
                </form>
            ';

                $num_correct = 0;
                $q_num = 1;
                while ($q_num <= 10) {
                    $rs = $conn->query('SELECT `qid`, `contents` AS "question" FROM `questions` WHERE `qid` = ' . $_POST['qid_q' . $q_num])
                        or die('Błąd pobierania danych 0');

                    if ($rs->num_rows > 0) {
                        while ($rec = $rs->fetch_array()) {
                            $question = $rec['question'];
                            $question = str_replace('&', '&amp;', $question);
                            $question = str_replace('<', '&lt;', $question);
                            $question = str_replace('>', '&gt;', $question);
                            $question = str_replace('"', '&quot;', $question);
                            $question = str_replace('\'', '&#39;', $question);

                            echo '<table style="order: 2;" class="exam_table">
                        <input type="hidden" name="qid_q' . $q_num . '" value="' . $rec['qid'] . '">
                        <tr>
                            <th class="exam_numhead">' . $q_num . '. ' . $question . '</th>
                        </tr>';

                            $rs1 = $conn->query('SELECT `aid`, `contents`  AS "answer", `is_correct` FROM `answers` WHERE `qid` = "' . $rec['qid'] . '" ')
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

                                    if ($rec1['is_correct']) {
                                        if ($rec1['aid'] == $_POST['aid_q' . $q_num]) {
                                            echo '
                                    <tr class="result_good">
                                        <td class="result_radans"><input type="radio" checked disabled name="aid_q' . $q_num . 'yeet' . $a_num . '"><label for="aid_q' . $q_num . 'yeet' . $a_num . '">  ' . chr($a_num) . '. ' . $answer . '</label></td>
                                    </tr>';

                                            if (!$is_old) {
                                                $rs2 = $conn->query('UPDATE `questions` SET `ans_total` = `ans_total` + 1, `ans_correct` = `ans_correct` + 1 WHERE `qid` = ' . $rec['qid'])
                                                    or die('Błąd wysyłania');
                                            }

                                            $num_correct += 1;
                                        } else {
                                            echo '
                                    <tr class="result_good">
                                        <td class="result_radans"><input type="radio" disabled name="aid_q' . $q_num . 'yeet' . $a_num . '"><label for="aid_q' . $q_num . 'yeet' . $a_num . '">  ' . chr($a_num) . '. ' . $answer . '</label></td>
                                    </tr>';
                                        }
                                    } else if ($rec1['aid'] == $_POST['aid_q' . $q_num]) {
                                        echo '
                                <tr class="result_bad">
                                    <td class="result_radans"><input type="radio" checked disabled name="aid_q' . $q_num . 'yeet' . $a_num . '"><label for="aid_q' . $q_num . 'yeet' . $a_num . '">  ' . chr($a_num) . '. ' . $answer . '</label></td>
                                </tr>';

                                        if (!$is_old) {
                                            $rs2 = $conn->query('UPDATE `questions` SET `ans_total` = `ans_total` + 1 WHERE `qid` = ' . $rec['qid'])
                                                or die('Błąd wysyłania');
                                        }
                                    } else {
                                        echo '
                                <tr>
                                <td class="result_radans"><input type="radio" disabled name="aid_q' . $q_num . 'yeet' . $a_num . '"><label for="aid_q' . $q_num . 'yeet' . $a_num . '">  ' . chr($a_num) . '. ' . $answer . '</label></td>
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
        <h2 style="order: 2;"> Twój wynik to: ' . ($num_correct / 10) * 100 .
                    '% (' . $num_correct . '/10)
        </h2>

        <h2 style="order: 1;"> Test zakończony. Twój wynik to: ' . ($num_correct / 10) * 100 .
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
        <form  style="order: 2;" action="/as-projekt/" method="GET">
            <button class="button_menu">Wróć do strony głównej</button>
        </form>
    ';
                ?>
            <?php
            } else {
                ?>
                <div id="loggedin_warning_box">
                    <div id="loggedin_warning_text">
                        Nie jesteś zalogowany!
                    </div>
                    <div id="loggedin_warning_buttons">
                        <form action="/as-projekt/login.php" method="GET">
                            <button>Zaloguj</button>
                        </form>
                        <form action="/as-projekt/register.php" method="GET">
                            <button>Zarejestruj</button>
                        </form>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div id="footer">
        <div id="footer_text">
            Projekt - 2019-11-07
        </div>
    </div>
</body>

</html>