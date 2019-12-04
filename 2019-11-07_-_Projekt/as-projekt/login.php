<?php
if (isset($_POST['login'])) {
  include('dbcredentials.php');
  $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

  if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

  $username = $_POST['username'];
  $username = str_replace('"', '\"', $username);

  $rs = $conn->query('SELECT `perm_level` FROM `users` WHERE `username` = "' . $username . '" AND `password` = "' . $_POST['password'] . '"')
    or die('Błąd pobierania danych');

  if ($rs->num_rows > 0) {
    $passlogin = true;
    setcookie('username', $username, time() + (86400), "/as-projekt/");
    setcookie('password', $_POST['password'], time() + (86400), "/as-projekt/");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Logowanie</title>

  <link rel="stylesheet" href="style.css">

  <script>
    function passToBase64() {
      document.getElementById('send_passwd').value = btoa(document.getElementById('input_passwd').value)

      document.getElementById('form_login').submit()
    }
  </script>

  <?php
  if ($passlogin || isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
    ?>
    <meta http-equiv="refresh" content="0; url=/as-projekt/" />
  <?php
  }
  ?>
</head>

<body>
  <div id="header">
    <div id="header_helper"></div>
    <h1> Logowanie </h1>
    <div id="header_helper"></div>
  </div>
  <div id="main_box">
    <div id="logreg_content_box">
      <?php
      if (isset($_POST['login'])) {
        include('dbcredentials.php');
        $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

        if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

        $rs = $conn->query('SELECT `perm_level` FROM `users` WHERE `username` = "' . $username . '" AND `password` = "' . $_POST['password'] . '"')
          or die('Błąd pobierania danych');

        if ($rs->num_rows > 0) {
          $passlogin = true;
        }
      }

      if ($passlogin) {
        echo '<h1>Zalogowano: ' . $_POST['username'] . '</h1>';
        ?>
        <form action="/as-projekt/" method="GET">
          <button class="button_menu">Wróć do strony głównej</button>
        </form>
      <?php
      } else if (isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
        echo '<h1>Zalogowano: ' . str_replace('\\"', '"', $_COOKIE['username']) . '</h1>';
        ?>
        <form action="/as-projekt/" method="GET">
          <button class="button_menu">Wróć do strony głównej</button>
        </form>
        <?php
        } else {
          if (isset($_POST['login'])) {
            ?>
          <h1>Nieprawidłowe dane logowania</h1>
          <form action="/as-projekt/login.php" method="GET">
            <button class="button_menu">Wróć do strony logowania</button>
          </form>
        <?php
          } else {
            ?>
          <div id="input_cont">
            <h1>Zaloguj</h1>
            <form id="form_login" class="big_form" method="POST">
              <input type="hidden" name="login" value="true">
              <div class="input_elem">
                <label for="username">Username</label>
                <input type="text" maxlength=15 name="username" required>
              </div>
              <div class="input_elem">
                <input id="send_passwd" type="hidden" name="password">
                <label for="password">Hasło</label>
                <input id="input_passwd" type="password" maxlength=16 required>
              </div>
              <button type="button" class="button_menu" onclick="passToBase64()">Zaloguj</button>
            </form>
            <form action="/as-projekt/" method="GET">
              <button class="button_menu">Wróć do strony głównej</button>
            </form>
          </div>
      <?php
        }
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