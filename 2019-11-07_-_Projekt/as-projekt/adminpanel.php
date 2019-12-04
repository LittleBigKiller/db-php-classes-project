<?php
include 'dbcredentials.php';
$conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

if ($conn->connect_errno) {
  die('Nie można się połączyć z bazą danych');
}

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
  $contents = $_POST['contents'];
  $contents = str_replace('"', '\"', $contents);

  if ($_POST['action'] == 'save_question') {
    $rs = $conn->query('UPDATE `questions` SET `contents`="' . $contents . '" WHERE `qid`="' . $_POST['qid'] . '"')
      or die('Błędne dane');
  } else if ($_POST['action'] == 'delete_question') {
    $rs = $conn->query('DELETE FROM `questions` WHERE `qid`="' . $_POST['qid'] . '"')
      or die('Błędne dane');
  } else if ($_POST['action'] == 'add_question') {
    $rs = $conn->query('INSERT INTO `questions`(`contents`) VALUES ("' . $contents . '")')
      or die('Błędne dane');
  } else if ($_POST['action'] == 'edit_answer') {
    $rs = $conn->query('UPDATE `answers` SET `contents`="' . $contents . '" WHERE `aid`="' . $_POST['aid'] . '"')
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
    $rs = $conn->query('INSERT INTO `answers`(`contents`, `qid`) VALUES ("' . $contents . '", "' . $_POST['qid'] . '")')
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

  <!-- <style>
        td {
            text-align: center;
        }
    </style> -->

  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php
  $is_loggedin = false;
  if (isset($_COOKIE['username']) and isset($_COOKIE['password']) and !isset($_POST['logout'])) {
    $is_loggedin = true;
  }

  include 'dbcredentials.php';
  $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

  if ($conn->connect_errno) {
    die('Nie można się połączyć z bazą danych');
  }

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
          Zalogowany jako: <b><?php echo (str_replace('\\"', '"', $_COOKIE['username'])) ?></b>
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



  <?php
  if (isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
    $rs = $conn->query('SELECT `perm_level` FROM `users` WHERE `username` = "' . $_COOKIE['username'] . '" AND `password` = "' . $_COOKIE['password'] . '"')
      or die('Błąd pobierania danych 0');

    $rec = $rs->fetch_array();

    if ($rs->num_rows != 0) {
      $is_admin = false;
      if ($rec['perm_level'] == '1') {
        $is_admin = true;
      }

      if ($is_admin) {
        ?>
        <div id="main_box">
          <div id="admin_nav_box">
            <form action="/as-projekt/" method="GET">
              <button>Zamknij Panel Administracyjny</button>
            </form>
            <h2>Panel Administracyjny</h2>
            <?php
                  if (isset($_POST['submenu'])) {
                    ?>
              <form action="/as-projekt/adminpanel.php" method="GET">
                <button>Strona Główna</button>
              </form>
            <?php
                  } else {
                    ?>
              <form action="/as-projekt/adminpanel.php" method="GET">
                <button disabled>Strona Główna</button>
              </form>
            <?php
                  }
                  if ($_POST['submenu'] == 'users') {
                    ?>
              <form action="/as-projekt/adminpanel.php" method="POST">
                <input type="hidden" name="submenu" value="users">
                <button disabled>Zarządzaj Użytkownikami</button>
              </form>
            <?php
                  } else {
                    ?>
              <form action="/as-projekt/adminpanel.php" method="POST">
                <input type="hidden" name="submenu" value="users">
                <button>Zarządzaj Użytkownikami</button>
              </form>
            <?php
                  }
                  if ($_POST['submenu'] == 'questions') {
                    ?>

              <form action="/as-projekt/adminpanel.php" method="POST">
                <input type="hidden" name="submenu" value="questions">
                <button disabled>Zarządzaj Pytaniami</button>
              </form>
            <?php
                  } else {
                    ?>

              <form action="/as-projekt/adminpanel.php" method="POST">
                <input type="hidden" name="submenu" value="questions">
                <button>Zarządzaj Pytaniami</button>
              </form>
            <?php
                  }
                  ?>
          </div>
          <div id="admin_content_box">
            <?php
                  if ($_POST['submenu'] == 'users') {
                    ?>
              <div id="toptable_box">
                <div class="toptable">
                  <h2> Zarządzaj użytkownikami
                    <?php
                            if ($_POST['action'] == 'delete') { ?>
                      <div style="color: green"> Usunięto użytkownika </div>
                    <?php
                            } else if ($_POST['action'] == 'save') { ?>
                      <div style="color: green"> Zapisano zmiany </div>
                    <?php
                            } else if ($_POST['action'] == 'discard') { ?>
                      <div style="color: green"> Odrzucono zmiany </div>
                    <?php
                            }
                            ?>
                  </h2>
                  <?php
                          $rs = $conn->query('SELECT `uid`, `username`, `perm_level` FROM `users`')
                            or die('Błąd pobierania danych 1');

                          if ($rs->num_rows > 0) { ?>
                    <table class="toptable">
                      <tr>
                        <th>Nazwa Użytkownika</th>
                        <th>Permisje</th>
                        <th>Akcje</th>
                        <th>Poprawne odpowiedzi</th>
                        <th>Niepoprawne odpowiedzi</th>
                      </tr>
                      <?php
                                while ($rec = $rs->fetch_array()) {
                                  if ($_POST['action'] == 'edit' && $_POST['uid'] == $rec['uid']) {

                                    $option_string = '<option value="0" selected> użytkownik </option>
                                    <option value="1"> administrator </option>';

                                    if ($rec['perm_level'] == 1) {
                                      $option_string = '<option value="0"> użytkownik </option>
                                    <option value="1" selected> administrator </option>';
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
                                    ?>

                          <form action="/as-projekt/adminpanel.php" method="POST">
                            <input type="hidden" name="submenu" value="users">
                            <input type="hidden" name="uid" value="<?php echo ($rec['uid']) ?>">
                            <tr>
                              <td><input type="text" name="username" minlength=6 maxlength=15 required value="<?php echo ($rec['username']) ?>"></td>
                              <td>
                                <select name="perm_level">
                                  <?php echo ($option_string) ?>
                                </select>
                              </td>
                              <td>
                                <button name="action" value="save">Zapisz</button>
                                <button name="action" value="discard">Odrzuć</button>
                              </td>
                              <td>
                                <?php echo ($ans_correct) ?>
                              </td>
                              <td>
                                <?php echo ($ans_incorrect) ?>
                              </td>
                            </tr>
                          </form>
                        <?php
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
                                      ?>
                          <form action="/as-projekt/adminpanel.php" method="POST">
                            <input type="hidden" name="submenu" value="users">
                            <input type="hidden" name="uid" value="<?php echo ($rec['uid']) ?>">
                            <tr>
                              <td><?php echo ($rec['username']) ?></td>
                              <td><?php echo ($perm_text) ?></td>
                              <td>
                                <button name="action" value="edit">Edytuj</button>
                                <button name="action" value="delete">Usuń</button>
                              </td>
                              <td>
                                <?php echo ($ans_correct) ?>
                              </td>
                              <td>
                                <?php echo ($ans_incorrect) ?>
                              </td>
                            </tr>
                          </form>
                      <?php
                                  }
                                }
                                ?>

                    </table>
                    <h3></h3>
                </div>
              </div>
            <?php
                    }
                  } else if ($_POST['submenu'] == 'questions') {
                    if ($_POST['action'] == 'edit_question' || $_POST['action'] == 'save_question' || $_POST['action'] == 'create_answer' || $_POST['action'] == 'add_answer' || $_POST['action'] == 'delete_answer' || $_POST['action'] == 'edit_answer' || $_POST['action'] == 'set_answer') {
                      ?>
              <?php
                        $rs = $conn->query('SELECT `contents` AS "question" FROM `questions` WHERE `qid` = ' . $_POST['qid'])
                          or die('Błąd pobierania danych');

                        if ($rs->num_rows > 0) {
                          ?>
                <div id="toptable_box">
                  <div class="toptable">
                    <h2> Edytuj Pytanie </h2>
                    <table class="toptable">
                      <?php
                                  while ($rec = $rs->fetch_array()) {
                                    ?>
                        <tr>
                          <form id="question_cancel" action="/as-projekt/adminpanel.php" method="POST">
                            <input type="hidden" name="submenu" value="questions">
                          </form>
                          <form id="question_edit" action="/as-projekt/adminpanel.php" method="POST">
                            <input type="hidden" name="submenu" value="questions">
                            <input type="hidden" name="qid" value="<?php echo ($_POST['qid']) ?>">
                            <th>Treść pytania: </th>
                            <td class="toptable_fieldbig"><textarea name="contents"><?php echo ($rec['question']) ?></textarea></td>
                          </form>
                          <td class="toptable_fieldbig">
                            <button name="action" form="question_edit" value="save_question">Zmień Treść</button>
                            <button name="action" form="question_cancel" value="none">Zakończ Edycje</button>
                          </td>
                        </tr>

                        <?php
                                      $rs1 = $conn->query('SELECT `aid`, `contents` AS "answer", `is_correct`, `qid` FROM `answers` WHERE `qid` = ' . $_POST['qid']);
                                      if ($rs1->num_rows > 0) {
                                        ?>
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
                          <?php
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
                                            ?>
                            <tr>
                              <form action="/as-projekt/adminpanel.php" method="POST">
                                <input type="hidden" name="submenu" value="questions">
                                <input type="hidden" name="qid" value="<?php echo ($_POST['qid']) ?>">
                                <input type="hidden" name="aid" value="<?php echo ($rec1['aid']) ?>">
                                <td><textarea name="contents"><?php echo ($answer) ?></textarea></td>
                                <td><?php echo ($is_correct) ?></td>
                                <td>
                                  <button name="action" value="edit_answer">Zmień Treść</button>
                                  <button name="action" value="set_answer">Ustaw Poprawną</button>
                                  <button name="action" value="delete_answer">Usuń</button>
                                </td>
                              </form>
                            </tr>
                          <?php
                                          }

                                          if ($_POST['action'] == 'create_answer') {
                                            ?>
                            <tr>
                              <form action="/as-projekt/adminpanel.php" method="POST">
                                <input type="hidden" name="submenu" value="questions">
                                <input type="hidden" name="qid" value="<?php echo ($_POST['qid']) ?>">
                                <td><textarea name="contents"></textarea></td>
                                <td>NIE</td>
                                <td>
                                  <button name="action" value="add_answer">Dodaj</button>
                                  <button name="action" value="edit_question">Anuluj</button>
                                </td>
                              </form>
                            </tr>
                          <?php
                                          } else if ($rs1->num_rows < 4) {
                                            ?>
                            <tr>
                              <form action="/as-projekt/adminpanel.php" method="POST">
                                <input type="hidden" name="submenu" value="questions">
                                <input type="hidden" name="qid" value="<?php echo ($_POST['qid']) ?>">
                                <td colspan="2"> Utwórz nową odpowiedź </td>
                                <td><button name="action" value="create_answer">Utwórz</button></td>
                              </form>
                            </tr>
                          <?php
                                          }
                                        } else {
                                          if ($_POST['action'] == 'create_answer') {
                                            ?>
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
                                <input type="hidden" name="qid" value="<?php echo ($_POST['qid']) ?>">
                                <td><textarea name="contents"></textarea></td>
                                <td>NIE</td>
                                <td>
                                  <button name="action" value="add_answer">Dodaj</button>
                                  <button name="action" value="edit_question">Anuluj</button>
                                </td>
                              </form>
                            </tr>
                          <?php
                                          } else {
                                            ?><tr>
                              <form action="/as-projekt/adminpanel.php" method="POST">
                                <input type="hidden" name="submenu" value="questions">
                                <input type="hidden" name="qid" value="<?php echo ($_POST['qid']) ?>">
                                <td colspan="2"> To pytanie nie ma na chwilę obecną żadnych odpowiedzi </td>
                                <td><button name="action" value="create_answer">Utwórz</button></td>
                              </form>
                            </tr>
                      <?php
                                      }
                                    }
                                  }
                                  ?>
                    </table>
                    <h3></h3>
                  </div>
                </div>
              <?php
                        }
                      } else if ($_POST['action'] == 'create_question') {
                        ?>
              <div id="toptable_box">
                <div class="toptable">
                  <h2> Utwórz Pytanie </h2>
                  <table class="toptable">
                    <tr>
                      <form id="question_cancel" action="/as-projekt/adminpanel.php" method="POST">
                        <input type="hidden" name="submenu" value="questions">
                      </form>
                      <form id="question_create" action="/as-projekt/adminpanel.php" method="POST">
                        <input type="hidden" name="submenu" value="questions">
                        <th>Treść pytania: </th>
                        <td class="toptable_fieldbig"><textarea name="contents"><?php echo ($rec['question']) ?></textarea></td>
                      </form>
                      <td class="toptable_fieldbig">
                        <button form="question_create" name="action" value="add_question">Dodaj Pytanie</button>
                        <button form="question_cancel" name="action" value="none">Anuluj</button>
                      </td>
                    </tr>
                  </table>
                  <h3></h3>
                </div>
              </div>
            <?php
                    }
                    ?>

            <div id="toptable_box">
              <div class="toptable">
                <h2> Zarządzaj Pytaniami </h2>

                <?php
                        $rs = $conn->query('SELECT `questions`.`qid`, `questions`.`contents` AS "question", `questions`.`ans_correct` AS "correct", (`questions`.`ans_total` - `questions`.`ans_correct`) AS "incorrect",
                        COUNT(`answers`.`aid`) AS "ans_count", SUM(`answers`.`is_correct`) AS "ans_correct" FROM `questions` LEFT JOIN `answers` ON `questions`.`qid` = `answers`.`qid` GROUP BY `questions`.`qid`')
                          or die('Błąd pobierania danych');
                        ?>

                <table class="toptable">
                  <tr>
                    <form action="/as-projekt/adminpanel.php" method="POST">
                      <input type="hidden" name="submenu" value="questions">
                      <th colspan="3">Utwórz nowe pytanie</th>
                      <td>
                        <button name="action" value="create_question">Utwórz</button>
                      </td>
                    </form>
                  </tr>
                  <tr>
                    <th>Pytanie</th>
                    <th>Poprawne Odpowiedzi</th>
                    <th>Niepoprawne Odpowiedzi</th>
                    <th>Akcje</th>
                  </tr>
                  <?php
                          if ($rs->num_rows > 0) {
                            while ($rec = $rs->fetch_array()) {
                              $question = '<td class="toptable_fieldbig">' . $rec['question'] . '</td>';
                              if ($rec['ans_count'] != 4 || $rec['ans_correct'] != 1) {
                                $question = '<td class="toptable_fieldbig toptable_fieldwrong" title="Za mało odpowiedzi lub brak poprawnej odpowiedzi">' . $rec['question'] . '</td>';
                              }
                              ?>

                      <tr>
                        <form action="/as-projekt/adminpanel.php" method="POST">
                          <input type="hidden" name="submenu" value="questions">
                          <input type="hidden" name="qid" value="<?php echo ($rec['qid']) ?>">
                          <?php echo ($question) ?>
                          <td><?php echo ($rec['correct']) ?></td>
                          <td><?php echo ($rec['incorrect']) ?></td>
                          <td>
                            <button name="action" value="edit_question">Edytuj</button>
                            <button name="action" value="delete_question">Usuń</button>
                          </td>
                        </form>
                      </tr>
                  <?php
                            }
                          }
                          ?>
                </table>
                <h3></h3>
              </div>
            </div>
          <?php
                } else {
                  ?>
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
                        <?php echo ((strlen($rec['username']) < 15 ? '<td>' . $rec['username'] : '<td title="' . $rec['username'] . '">' . substr($rec['username'], 0, 12) . '...')) ?>
                        </td>
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
                        <?php echo ((strlen($rec['question']) < 120 ? '<td style="width: 320px">' . $rec['question'] : '<td style="width: 320px" title="' . $rec['question'] . '">' . substr($rec['question'], 0, 117) . '...')) ?>
                        </td>
                        <td><?php echo ($rec['total']) ?></td>
                        <td><?php echo (($rec['total'] != 0 ? round($rec['correct'] / $rec['total'] * 100, 2) : '0')) ?>%
                        </td>
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
          <?php
                }
                ?>
          </div>
        </div>
      <?php
          } else {
            ?>

        <div id="loggedin_warning_box">
          <div id="loggedin_warning_text">
            Nie masz dostępu do tej zawartości
          </div>
          <div id="loggedin_warning_buttons">
            <form action="/as-projekt/" method="GET">
              <button>Wróć do strony głównej</button>
            </form>
          </div>
        </div>
      <?php
          }
        } else {
          ?>
      <div id="loggedin_warning_box">
        <div id="loggedin_warning_text">
          Nie masz dostępu do tej zawartości
        </div>
        <div id="loggedin_warning_buttons">
          <form action="/as-projekt/" method="GET">
            <button>Wróć do strony głównej</button>
          </form>
        </div>
      </div>
    <?php
      }
    } else {
      ?>
    <div id="loggedin_warning_box">
      <div id="loggedin_warning_text">
        Nie masz dostępu do tej zawartości
      </div>
      <div id="loggedin_warning_buttons">
        <form action="/as-projekt/" method="GET">
          <button>Wróć do strony głównej</button>
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