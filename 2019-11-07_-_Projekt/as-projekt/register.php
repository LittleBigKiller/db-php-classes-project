<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register</title>

  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div id="header">
    <div id="header_helper"></div>
    <h1> Rejestracja </h1>
    <div id="header_helper"></div>
  </div>
  <div id="main_box">
    <div id="logreg_content_box">
      <?php
      include('dbcredentials.php');
      $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

      if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

      if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $username = str_replace('"', '\"', $username);

        $rs = $conn->query('SELECT `users`.`username` FROM `users` WHERE `username` = "' . $username . '"')
          or die('Błąd pobierania danych');

        if ($rs->num_rows == 0) {
          $rs = $conn->query('INSERT INTO `users`(`username`, `password`, `perm_level`) VALUES ("' . $username . '", "' . md5($_POST['password']) . '", 0)')
            or die('<h1>Błąd rejestracji</h1>
                    <form action="/as-projekt/" method="GET">
                        <button class="button_menu">Wróć do strony głównej</button>
                    </form>
                    <form action="/as-projekt/register.php" method="GET">
                        <button class="button_menu">Wróć do rejestracji</button>
                    </form>
                    </div></div>
                    <div id="footer">
                        <div id="footer_text">
                            Projekt - 2019-11-07
                        </div>
                    </div>');

          echo '<h1>Zarejestrowano użytkownika: ' . $_POST['username'] . '</h1>';
          ?>
          <form action="/as-projekt/" method="GET">
            <button class="button_menu">Wróć do strony głównej</button>
          </form>
          <form action="/as-projekt/login.php" method="GET">
            <button class="button_menu">Zaloguj się</button>
          </form>
        <?php
          } else {
            ?>
          <h1>Użytkownik istnieje</h1>
          <form action="/as-projekt/" method="GET">
            <button class="button_menu">Wróć do strony głównej</button>
          </form>
          <form action="/as-projekt/register.php" method="GET">
            <button class="button_menu">Wróć do rejestracji</button>
          </form>
        <?php
          }
        } else {
          ?>
        <div id="input_cont">
          <h1>Zarejestruj</h1>
          <form class="big_form" method="POST">
            <input type="hidden" name="register" value="true">
            <div class="input_elem">
              <label for="username">Username</label>
              <input type="text" minlength=6 maxlength=15 name="username" required>
            </div>
            <div class="input_elem">
              <label for="password">Password</label>
              <input type="password" minlength=6 maxlength=16 name="password" required>
            </div>
            <button class="button_menu">Zarejestruj</button>
          </form>
          <form action="/as-projekt/" method="GET">
            <button class="button_menu">Wróć do strony głównej</button>
          </form>
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