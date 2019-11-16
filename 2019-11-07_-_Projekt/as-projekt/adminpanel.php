<?php
include('dbcredentials.php');
$conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

$rs = $conn->query('SET NAMES utf8')
    or die('Nie udało się ustawić CHARSET');

if ($_POST['submenu'] == 'users') {
    if ($_POST['action'] == 'save') {
        $rs = $conn->query('UPDATE `users` SET `username`="' . $_POST['username'] . '", `perm_level`="' . $_POST['perm_level'] . '" WHERE `uid`="' . $_POST['uid'] . '"')
            or die('Błędne dane');
    } else if ($_POST['action'] == 'delete') {
        $rs = $conn->query('DELETE FROM `users` WHERE `uid`="' . $_POST['uid'] . '"')
            or die('Błędne dane');
    }
} else if ($_POST['submenu'] == 'questions') {
    if ($_POST['action'] == 'save_question') {
        $rs = $conn->query('UPDATE `questions` SET `contents`="' . $_POST['contents'] . '" WHERE `qid`="' . $_POST['qid'] . '"')
            or die('Błędne dane');
    } else if ($_POST['action'] == 'delete_question') {
        $rs = $conn->query('DELETE FROM `questions` WHERE `qid`="' . $_POST['qid'] . '"')
            or die('Błędne dane');
    } else if ($_POST['action'] == 'add_question') {
        $rs = $conn->query('INSERT INTO `questions`(`contents`) VALUES ("' . $_POST['contents'] . '")')
            or die('Błędne dane');
    } else if ($_POST['action'] == 'edit_answer') {
        $rs = $conn->query('UPDATE `answers` SET `contents`="' . $_POST['contents'] . '" WHERE `aid`="' . $_POST['aid'] . '"')
            or die('Błędne dane');
    } else if ($_POST['action'] == 'set_answer') {
        $rs = $conn->query('UPDATE `answers` SET `is_correct`=0 WHERE `qid`="' . $_POST['qid'] . '"')
            or die('Błędne dane');

        $rs = $conn->query('UPDATE `answers` SET `is_correct`=1 WHERE `aid`="' . $_POST['aid'] . '"')
            or die('Błędne dane');
    } else if ($_POST['action'] == 'delete_answer') {
        $rs = $conn->query('DELETE FROM `answers` WHERE `aid`="' . $_POST['aid'] . '"')
            or die('Błędne dane');
    } else if ($_POST['action'] == 'add_answer') {
        $rs = $conn->query('INSERT INTO `answers`(`contents`, `qid`) VALUES ("' . $_POST['contents'] . '", "' . $_POST['qid'] . '")')
            or die('Błędne dane');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel Administracyjny</title>

    <style>
        td {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
        $rs = $conn->query('SELECT `perm_level` FROM `users` WHERE `username` = "' . $_COOKIE['username'] . '" AND `password` = "' . $_COOKIE['password'] . '"')
            or die('Błąd pobierania danych');

        $rec = $rs->fetch_array();

        if ($rs->num_rows != 0) {
            $is_admin = false;
            if ($rec['perm_level'] == '1') {
                $is_admin = true;
            }

            if ($is_admin) {
                echo '
                    <h1> Panel Administracyjny </h1>

                    <form action="/as-projekt/" method="GET">
                        <button>Wróć do strony głównej</button>
                    </form>
                    ';

                if (isset($_POST['submenu'])) {
                    echo '
                        <form action="/as-projekt/adminpanel.php" method="GET">
                            <button>Wróć do planelu administracyjnego</button>
                        </form>
                        ';
                }

                if ($_POST['submenu'] == 'users') {
                    echo '
                        <h2> Zarządzaj użytkownikami </h2>
                        ';

                    $rs = $conn->query('SELECT `uid`, `username`, `perm_level` FROM `users`')
                        or die('Błąd pobierania danych');

                    $rs1 = $conn->query('SELECT `results`.`uid`, `users`.`username`, SUM(`results`.`ans_correct`), COUNT(`results`.`ans_correct`) * 10 FROM `users` INNER JOIN `results`
                        ON `users`.`uid` = `results`.`uid` GROUP BY `results`.`uid`');

                    if ($rs->num_rows > 0) {
                        echo '
                        <table border=1>
                        <tr>
                            <th>Nazwa Użytkownika</th>
                            <th>Permisje</th>
                            <th>Akcje</th>
                            <th>Poprawne odpowiedzi</th>
                            <th>Niepoprawne odpowiedzi</th>
                        </tr>
                        ';

                        while ($rec = $rs->fetch_array()) {
                            if ($_POST['action'] == 'edit' && $_POST['uid'] == $rec['uid']) {
                                $option_string = '               
                                    <option value="0" selected> użytkownik </option>
                                    <option value="1"> administrator </option>
                                    ';
                                if ($rec['perm_level'] == 1) {
                                    $option_string = '               
                                    <option value="0"> użytkownik </option>
                                    <option value="1" selected> administrator </option>
                                    ';
                                }

                                $rs1 = $conn->query('SELECT SUM(`results`.`ans_correct`) AS "correct", COUNT(`results`.`ans_correct`) * 10 - SUM(`results`.`ans_correct`) AS "incorrect"
                                    FROM `users` INNER JOIN `results` ON `users`.`uid` = `results`.`uid` GROUP BY `results`.`uid` HAVING `results`.`uid` = ' . $rec['uid']);

                                $ans_correct = 0;
                                $ans_incorrect = 0;
                                if ($rs1->num_rows != 0) {
                                    while ($rec1 = $rs1->fetch_array()) {
                                        $ans_correct = $rec1['correct'];
                                        $ans_incorrect = $rec1['incorrect'];
                                    }
                                }

                                echo '
                                <form action="/as-projekt/adminpanel.php" method="POST">
                                    <input type="hidden" name="submenu" value="users">
                                    <input type="hidden" name="uid" value="' . $rec['uid'] . '">
                                    <tr>
                                        <td><input type="text" name="username" minlength=6 maxlength=15 required value="' . $rec['username'] . '"></td>
                                        <td>
                                            <select name="perm_level">' .
                                    $option_string .
                                    '</select>
                                        </td>
                                        <td>
                                            <button name="action" value="save">Zapisz</button>
                                            <button name="action" value="discard">Odrzuć</button>
                                        </td>
                                        <td>' .
                                    $ans_correct . '
                                        </td>
                                        <td>' .
                                    $ans_incorrect . '
                                        </td>
                                    </tr>
                                </form>
                                ';
                            } else {
                                $perm_text = 'użytkownik';
                                if ($rec['perm_level'] == 1) {
                                    $perm_text = 'administrator';
                                }

                                $rs1 = $conn->query('SELECT SUM(`results`.`ans_correct`) AS "correct", COUNT(`results`.`ans_correct`) * 10 - SUM(`results`.`ans_correct`) AS "incorrect"
                                    FROM `users` INNER JOIN `results` ON `users`.`uid` = `results`.`uid` GROUP BY `results`.`uid` HAVING `results`.`uid` = ' . $rec['uid']);

                                $ans_correct = 0;
                                $ans_incorrect = 0;
                                if ($rs1->num_rows != 0) {
                                    while ($rec1 = $rs1->fetch_array()) {
                                        $ans_correct = $rec1['correct'];
                                        $ans_incorrect = $rec1['incorrect'];
                                    }
                                }

                                echo '
                                <form action="/as-projekt/adminpanel.php" method="POST">
                                    <input type="hidden" name="submenu" value="users">
                                    <input type="hidden" name="uid" value="' . $rec['uid'] . '">
                                    <tr>
                                        <td>' . $rec['username'] . '</td>
                                        <td>' . $perm_text . '</td>
                                        <td>
                                            <button name="action" value="edit">Edytuj</button>
                                            <button name="action" value="delete">Usuń</button>
                                        </td>
                                        <td>' .
                                    $ans_correct . '
                                        </td>
                                        <td>' .
                                    $ans_incorrect . '
                                        </td>
                                    </tr>
                                </form>
                                ';
                            }
                        }

                        echo '</table>';

                        if ($_POST['action'] == 'delete') {
                            echo '
                                <h3 style="color: green"> Usunięto użytkownika </h3>
                                ';
                        } else if ($_POST['action'] == 'save') {
                            echo '
                                <h3 style="color: green"> Zapisano zmiany </h3>
                                ';
                        } else if ($_POST['action'] == 'discard') {
                            echo '
                                <h3 style="color: green"> Odrzucono zmiany </h3>
                                ';
                        }
                    }

                    echo '
                        <h2> 10 najlepszych użytkowników </h2>
                        ';

                    $rs = $conn->query('SELECT `users`.`username` AS "username", AVG(`results`.`ans_correct`) AS "avg" FROM `results` INNER JOIN `users` ON `results`.`uid` = `users`.`uid` GROUP BY `results`.`uid` ORDER BY AVG(`results`.`ans_correct`) DESC LIMIT 10')
                        or die('Błąd pobierania danych');

                    if ($rs->num_rows > 0) {
                        echo '<table border=1>
                            <tr><th>Użytkownik</th><th>Średnia Ocen</th></tr>';
                        while ($rec = $rs->fetch_array()) {
                            echo "<tr>
                                <td>" . $rec["username"] . "</td>
                                <td>" . ($rec["avg"] * 10) . "%</td>
                                </tr>";
                        }

                        echo '</table>';
                    }

                    $rs->close();
                } else if ($_POST['submenu'] == 'questions') {
                    echo '
                        <h2> Zarządzaj Pytaniami </h2>
                        ';

                    $rs = $conn->query('SELECT `qid`, `contents` AS "question", `ans_correct` AS "correct", (`ans_total` - `ans_correct`) AS "incorrect" FROM `questions` ')
                        or die('Błąd pobierania danych');


                    echo '<table border=1>
                            <tr>
                                <th>Pytanie</th>
                                <th>Poprawne Odpowiedzi</th>
                                <th>Niepoprawne Odpowiedzi</th>
                                <th>Akcje</th>
                            </tr>';
                    if ($rs->num_rows > 0) {
                        while ($rec = $rs->fetch_array()) {
                            echo '<tr>
                                    <form action="/as-projekt/adminpanel.php" method="POST">
                                        <input type="hidden" name="submenu" value="questions">
                                        <input type="hidden" name="qid" value="' . $rec['qid'] . '">
                                        <td>' . $rec['question'] . '</td>
                                        <td>' . $rec['correct'] . '</td>
                                        <td>' . $rec['incorrect'] . '</td>
                                        <td>
                                            <button name="action" value="edit_question">Edytuj</button>
                                            <button name="action" value="delete_question">Usuń</button>
                                        </td>
                                    </form>
                                </tr>';
                        }
                    }
                    echo '
                        <tr>
                            <form action="/as-projekt/adminpanel.php" method="POST">
                                <input type="hidden" name="submenu" value="questions">
                                <th colspan="3">Utwórz nowe pytanie</th>
                                <td>
                                    <button name="action" value="create_question">Utwórz</button>
                                </td>
                            </form>
                        </tr>';

                    echo '</table>';

                    if ($_POST['action'] == 'edit_question' || $_POST['action'] == 'create_answer' || $_POST['action'] == 'add_answer' || $_POST['action'] == 'delete_answer' || $_POST['action'] == 'edit_answer' || $_POST['action'] == 'set_answer') {
                        echo '
                            <h2> Edytuj Pytanie 
                                <form action="/as-projekt/adminpanel.php" method="POST">
                                    <input type="hidden" name="submenu" value="questions">
                                    <button name="action" value="none">Anuluj</button>
                                </form>
                            </h2>
                            ';

                        $rs = $conn->query('SELECT `contents` AS "question" FROM `questions` WHERE `qid` = ' . $_POST['qid'])
                            or die('Błąd pobierania danych');

                        if ($rs->num_rows > 0) {
                            echo '<table border=1>';
                            while ($rec = $rs->fetch_array()) {
                                echo '<tr>
                                        <form action="/as-projekt/adminpanel.php" method="POST">
                                            <input type="hidden" name="submenu" value="questions">
                                            <input type="hidden" name="qid" value="' . $_POST['qid'] . '">
                                            <th>Treść pytania: </th>
                                            <td><input type="text" name="contents" value="' . $rec['question'] . '"></td>
                                            <td><button name="action" value="save_question">Zmień Treść</button></td>
                                        </form>
                                    </tr>';

                                $rs1 = $conn->query('SELECT `aid`, `contents` AS "answer", `is_correct`, `qid` FROM `answers` WHERE `qid` = ' . $_POST['qid']);
                                if ($rs1->num_rows > 0) {
                                    echo '
                                        <tr>
                                            <th colspan>
                                                Treść Odpowiedzi
                                            </th>
                                            <th>
                                                Poprawna
                                            </th>
                                            <th>
                                                Akcje
                                            </th>
                                        </tr>';

                                    while ($rec1 = $rs1->fetch_array()) {
                                        $answer = $rec1['answer'];
                                        $answer = str_replace('&', '&amp;', $answer);
                                        $answer = str_replace('<', '&lt;', $answer);
                                        $answer = str_replace('>', '&gt;', $answer);
                                        $answer = str_replace('"', '&quot;', $answer);
                                        $answer = str_replace('\'', '&#39;', $answer);

                                        $is_correct = 'NIE';
                                        if ($rec1['is_correct'] == 1) {
                                            $is_correct = 'TAK';
                                        }

                                        echo '<tr>
                                                <form action="/as-projekt/adminpanel.php" method="POST">
                                                    <input type="hidden" name="submenu" value="questions">
                                                    <input type="hidden" name="qid" value="' . $_POST['qid'] . '">
                                                    <input type="hidden" name="aid" value="' . $rec1['aid'] . '">
                                                    <td><input type="text" name="contents" value="' . $answer . '"</td>
                                                    <td>' . $is_correct . '</td>
                                                    <td>
                                                        <button name="action" value="edit_answer">Zmień Treść</button>
                                                        <button name="action" value="set_answer">Ustaw Poprawną</button>
                                                        <button name="action" value="delete_answer">Usuń</button>
                                                    </td>
                                                </form>
                                            </tr>';
                                    }

                                    if ($_POST['action'] == 'create_answer') {
                                        echo '<tr>
                                                <form action="/as-projekt/adminpanel.php" method="POST">
                                                    <input type="hidden" name="submenu" value="questions">
                                                    <input type="hidden" name="qid" value="' . $_POST['qid'] . '">
                                                    <td><input type="text" name="contents" value=""</td>
                                                    <td>NIE</td>
                                                    <td>
                                                        <button name="action" value="add_answer">Dodaj</button>
                                                        <button name="action" value="edit_question">Anuluj</button>
                                                    </td>
                                                </form>
                                            </tr>';
                                    } else if ($rs1->num_rows < 4) {
                                        echo '<tr>
                                            <form action="/as-projekt/adminpanel.php" method="POST">
                                                <input type="hidden" name="submenu" value="questions">
                                                <input type="hidden" name="qid" value="' . $_POST['qid'] . '">
                                                <td colspan="2"> Utwórz nową odpowiedź </td>
                                                <td><button name="action" value="create_answer">Utwórz</button></td>
                                            </form>
                                        </tr>';
                                    }
                                } else {
                                    if ($_POST['action'] == 'create_answer') {
                                        echo '
                                            <tr>
                                                <th colspan>
                                                    Treść Odpowiedzi
                                                </th>
                                                <th>
                                                    Poprawna
                                                </th>
                                                <th>
                                                    Akcje
                                                </th>
                                            </tr>
                                            <tr>
                                                <form action="/as-projekt/adminpanel.php" method="POST">
                                                    <input type="hidden" name="submenu" value="questions">
                                                    <input type="hidden" name="qid" value="' . $_POST['qid'] . '">
                                                    <td><input type="text" name="contents" value=""</td>
                                                    <td>NIE</td>
                                                    <td>
                                                        <button name="action" value="add_answer">Dodaj</button>
                                                        <button name="action" value="edit_question">Anuluj</button>
                                                    </td>
                                                </form>
                                            </tr>';
                                    } else {
                                        echo '<tr>
                                            <form action="/as-projekt/adminpanel.php" method="POST">
                                                <input type="hidden" name="submenu" value="questions">
                                                <input type="hidden" name="qid" value="' . $_POST['qid'] . '">
                                                <td colspan="2"> To pytanie nie ma na chwilę obecną żadnych odpowiedzi </td>
                                                <td><button name="action" value="create_answer">Utwórz</button></td>
                                            </form>
                                        </tr>';
                                    }
                                }
                            }

                            echo '</table>';
                        }
                    } else if ($_POST['action'] == 'create_question') {
                        echo '
                            <h2> Dodaj Pytanie
                                <form action="/as-projekt/adminpanel.php" method="POST">
                                    <input type="hidden" name="submenu" value="questions">
                                    <button name="action" value="none">Anuluj</button>
                                </form>
                            </h2>
                            <table border=1>
                                <tr>
                                    <form action="/as-projekt/adminpanel.php" method="POST">
                                        <input type="hidden" name="submenu" value="questions">
                                        <th>Treść pytania: </th>
                                        <td><input type="text" name="contents" value="' . $rec['question'] . '"></td>
                                        <td>
                                            <button name="action" value="add_question">Dodaj</button>
                                        </td>
                                    </form>
                                </tr>
                            </table>';
                    } else {
                        echo '
                            <h2> 10 najtrudniejszych pytań </h2>
                            ';

                        $rs = $conn->query('SELECT `qid`, `contents` AS "question", `ans_correct` AS "correct", (`ans_total` - `ans_correct`) AS "incorrect", `ans_total` AS "total" FROM `questions` ORDER BY `ans_correct` / `ans_total` ASC LIMIT 10')
                            or die('Błąd pobierania danych');


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
                    }
                } else {
                    echo '
                        <h2> Zarządzaj </h2>

                        <form action="/as-projekt/adminpanel.php" method="POST">
                            <input type="hidden" name="submenu" value="users">
                            <button>Zarządzaj Użytkownikami</button>
                        </form>

                        <form action="/as-projekt/adminpanel.php" method="POST">
                            <input type="hidden" name="submenu" value="questions">
                            <button>Zarządzaj Pytaniami</button>
                        </form>
                        ';
                }
            } else {
                echo '
                <h1> Nie masz dostępu do tej zawartości </h1>

                <form action="/as-projekt/" method="GET">
                    <button>Wróć do strony głównej</button>
                </form>
                ';
            }
        } else {
            echo '
            <h1> Nie masz dostępu do tej zawartości </h1>

            <form action="/as-projekt/" method="POST">
                <input type="hidden" name="logout" value="true">
                <button>Wróć do strony głównej</button>
            </form>
            ';
        }
    } else {
        echo '
            <h1> Nie masz dostępu do tej zawartości </h1>

            <form action="/as-projekt/" method="GET">
                <button>Wróć do strony głównej</button>
            </form>
            ';
    }
    ?>
</body>

</html>