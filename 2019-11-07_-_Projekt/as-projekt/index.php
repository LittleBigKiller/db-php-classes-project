<?php
if (isset($_POST['logout'])) {
  setcookie('username', $_POST['username'], time() - (86400 * 30), "/as-projekt/");
  setcookie('password', md5($_POST['password']), time() - (86400 * 30), "/as-projekt/");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Main Page</title>

  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php
  $is_loggedin = false;
  if (isset($_COOKIE['username']) and isset($_COOKIE['password']) and !isset($_POST['logout'])) {
    $is_loggedin = true;
  }

  include('dbcredentials.php');
  $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

  if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

  $conn->query('SET NAMES utf8')
    or die('Nie udało się ustawić CHARSET');
  ?>

  <div id="header">
    <div id="header_helper"></div>
    <h1> Strona główna </h1>
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
  <?php
  if ($is_loggedin) {
    if (!isset($_POST['show-personal'])) {
      ?>
      <div id="index_main_box">
        <div id="index_nav_box">
          <form action="/as-projekt/exam.php" method="GET">
            <button id="index_start">Rozpocznij Test 10 Pytań</button>
          </form>
          <form action="/as-projekt/" method="POST">
            <input type="hidden" name="show-personal" value="true">
            <button id="index_start">Moje Statystyki</button>
          </form>
          <?php
              if ($is_admin) {
                ?>
            <form action="/as-projekt/adminpanel.php" method="GET">
              <button id="loggedin_adminbutton">Otwórz Panel Administracyjny</button>
            </form>
          <?php
              }
              ?>
        </div>
        <div id="index_content_box">
          <div id="toptable_box">
            <div class="toptable">
              <h2> 10 najlepszych użytkowników </h2>
              <?php
                  $rs = $conn->query('SELECT `users`.`username` AS "username", AVG(`results`.`ans_correct`) AS "avg" FROM `results` INNER JOIN `users` ON `results`.`uid` = `users`.`uid` GROUP BY `results`.`uid` ORDER BY AVG(`results`.`ans_correct`) DESC LIMIT 10')
                    or die('Błąd pobierania danych');
                  ?>
              <table class="toptable">
                <tr>
                  <th>Użytkownik</th>
                  <th>Średnia Ocen</th>
                </tr>

                <?php
                    if ($rs->num_rows > 0) {
                      while ($rec = $rs->fetch_array()) {
                        ?>
                    <tr>
                      <?php echo ((strlen($rec['username']) < 15 ? '<td>' . $rec['username'] : '<td title="' . $rec['username'] . '">' . substr($rec['username'], 0, 12) . '...')) ?></td>
                      <td><?php echo (round($rec['avg'] * 10, 2)) ?>%</td>
                    </tr>
                  <?php
                        }
                      } else {
                        ?>
                  <tr>
                    <td colspan="2">Brak Danych</td>
                  </tr>
                <?php
                    }
                    ?>
              </table>
              <h3> </h3>
            </div>
            <div class="toptable">
              <h2> 10 najtrudniejszych pytań </h2>
              <?php
                  $rs = $conn->query('SELECT `qid`, `contents` AS "question", `ans_correct` AS "correct", (`ans_total` - `ans_correct`) AS "incorrect", `ans_total` AS "total" FROM `questions` HAVING `ans_total` > 0 ORDER BY `ans_correct` / `ans_total` ASC LIMIT 10')
                    or die('Błąd pobierania danych');
                  ?>
              <table class="toptable">
                <tr>
                  <th>Pytanie</th>
                  <th>Ilość odpowiedzi</th>
                  <th>Procent Poprawnych</th>
                </tr>

                <?php
                    if ($rs->num_rows > 0) {
                      while ($rec = $rs->fetch_array()) {
                        ?>
                    <tr>
                      <?php echo ((strlen($rec['question']) < 120 ? '<td style="width: 320px">' .  $rec['question'] : '<td style="width: 320px" title="' . $rec['question'] . '">' . substr($rec['question'], 0, 117) . '...')) ?></td>
                      <td><?php echo ($rec['total']) ?></td>
                      <td><?php echo (($rec['total'] != 0 ? round($rec['correct'] / $rec['total'] * 100, 2) : '0')) ?>%</td>
                    </tr>
                  <?php
                        }
                      } else {
                        ?>
                  <tr>
                    <td colspan="2">Brak Danych</td>
                  </tr>
                <?php
                    }
                    ?>
              </table>
              <h3> </h3>
            </div>
          </div>
        </div>
      </div>
    <?php
      } else {
        ?>
      <div id="index_main_box">
        <div id="index_nav_box">
          <form action="/as-projekt/exam.php" method="GET">
            <button id="index_start">Rozpocznij Test 10 Pytań</button>
          </form>
          <form action="/as-projekt/" method="GET">
            <input type="hidden">
            <button id="index_start">Użytkownicy i Pytania</button>
          </form>
          <?php
              if ($is_admin) {
                ?>
            <form action="/as-projekt/adminpanel.php" method="GET">
              <button id="loggedin_adminbutton">Otwórz Panel Administracyjny</button>
            </form>
          <?php
              }
              ?>
        </div>
        <div id="index_content_box">
          <div id="toptable_box">
            <div class="toptable">
              <h2> Moje Statystyki </h2>
              <?php
                  $rs0 = $conn->query('SELECT `uid` FROM `users` WHERE `username` = "' . $_COOKIE['username'] . '"')
                    or die('Błąd pobierania danych 0');

                  $rec0 = $rs0->fetch_array();

                  $rs = $conn->query('SELECT `users`.`uid`, `users`.`username` AS "username", AVG(`results`.`ans_correct`) AS "avg", SUM(`results`.`ans_correct`) AS "correct",
                                    COUNT(`results`.`ans_correct`) * 10 - SUM(`results`.`ans_correct`) AS "incorrect", COUNT(`results`.`ans_correct`) * 10 AS "total"
                                    FROM `results` INNER JOIN `users` ON `results`.`uid` = `users`.`uid` GROUP BY `results`.`uid` HAVING `users`.`uid` = "' . $rec0['uid'] . '"')
                    or die('Błąd pobierania danych 1');


                  ?>
              <table class="toptable">
                <tr>
                  <th>Nazwa Użytkownika</th>
                  <th>Poprawne Odpowiedzi</th>
                  <th>Niepoprawne Odpowiedzi</th>
                  <th>Średnia Ocen</th>
                  <th>Wszystkie Odpowiedzi</th>
                </tr>

                <?php

                    if ($rs->num_rows > 0) {
                      while ($rec = $rs->fetch_array()) {
                        ?>
                    <tr>
                      <?php echo ((strlen($rec['username']) < 15 ? '<td>' . $rec['username'] : '<td title="' . $rec['username'] . '">' . substr($rec['username'], 0, 12) . '...')) ?></td>
                      <td><?php echo ($rec['correct']) ?></td>
                      <td><?php echo ($rec['incorrect']) ?></td>
                      <td><?php echo (round($rec['avg'] * 10, 2)) ?>%</td>
                      <td><?php echo ($rec['total']) ?></td>
                    </tr>
                  <?php
                        }
                      } else {
                        ?>
                  <tr>
                    <td colspan="5">Brak Danych - Rozwiąż Test 10 Pytań</td>
                  </tr>
                <?php
                    }
                    ?>
              </table>
              <h3> </h3>
            </div>
          </div>
        </div>
      </div>
    <?php
      }
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