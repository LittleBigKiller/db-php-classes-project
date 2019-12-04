<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Test 10 Pytań</title>

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
    <h1> Test 10 Pytań </h1>
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
        ?>
        <b>Nie jesteś zalogowany!</b>
      <?php
      }
      ?>
    </div>
  </div>
  <div id="main_box">
    <div id="scroll_content_box">
      <?php
      if ($is_loggedin) {
        $rs = $conn->query('SELECT `questions`.`qid`, `questions`.`contents` AS "question" FROM `questions` LEFT JOIN `answers` ON `questions`.`qid` = `answers`.`qid`
        GROUP BY `questions`.`qid`HAVING COUNT(`answers`.`aid`) = 4 AND SUM(`answers`.`is_correct`) = 1 ORDER BY RAND() LIMIT 10 ')
          or die('Błąd pobierania danych 0');

        echo '<form action="/as-projekt/results.php" method="POST">
                    <button class="button_menu exam_button" name="exam_end" value="' . time() . '">Zakończ podejście</button>';

        if ($rs->num_rows > 0) {
          $q_num = 1;
          while ($rec = $rs->fetch_array()) {
            $question = $rec['question'];
            $question = str_replace('&', '&amp;', $question);
            $question = str_replace('<', '&lt;', $question);
            $question = str_replace('>', '&gt;', $question);
            $question = str_replace('"', '&quot;', $question);
            $question = str_replace('\'', '&#39;', $question);

            echo '<table class="exam_table">
                            <input type="hidden" name="qid_q' . $q_num . '" value="' . $rec['qid'] . '">
                            <tr>
                                <th class="exam_numhead">' . $q_num . '. ' . $question . '</th>
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

                echo '<tr>
                                        <td class="exam_radans"><input type="radio" id="aid_q' . $rec1['aid'] . '" name="aid_q' . $q_num . '" value="' . $rec1['aid'] . '"><label onclick="document.getElementById(\'aid_q' . $rec1['aid'] . '\').checked = true" for="aid_q' . $q_num . '">  ' . chr($a_num) . '. ' . $answer . '</label></td>
                                    </tr>';

                $a_num += 1;
              }
            }
            echo '</table>';

            $q_num += 1;
          }
        }

        echo '
        <button class="button_menu exam_button" name="exam_end" value="' . time() . '">Zakończ podejście</button>
        </form>';
        ?>
    </div>
  </div>
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

<div id="footer">
  <div id="footer_text">
    Projekt - 2019-11-07
  </div>
</div>
</body>

</html>