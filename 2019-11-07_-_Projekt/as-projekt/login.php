<?php
if (isset($_POST['login'])) {
    include('dbcredentials.php');
    $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

    if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

    $rs = $conn->query('SELECT `perm_level` FROM `users` WHERE `username` = "' . $_POST['username'] . '" AND `password` = "' . md5($_POST['password']) . '"')
        or die('Błąd pobierania danych');

    if ($rs->num_rows > 0) {
        $passlogin = true;
        setcookie('username', $_POST['username'], time() + (86400 * 30), "/as-projekt/");
        setcookie('password', md5($_POST['password']), time() + (86400 * 30), "/as-projekt/");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>

<body>
    <?php
    $passlogin = false;

    if (isset($_POST['login'])) {
        include('dbcredentials.php');
        $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

        if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

        $rs = $conn->query('SELECT `perm_level` FROM `users` WHERE `username` = "' . $_POST['username'] . '" AND `password` = "' . md5($_POST['password']) . '"')
            or die('Błąd pobierania danych');

        if ($rs->num_rows > 0) {
            $passlogin = true;
        }
    }

    if ($passlogin) {
        echo '
            <h1>Zalogowano: ' . $_POST['username'] . '</h1>
            <form action="/as-projekt/" method="GET">
                <button>Wróć do strony głównej</button>
            </form>';
    } else if (isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
        echo '
            <h1>Zalogowano: ' . $_COOKIE['username'] . '</h1>
            <form action="/as-projekt/" method="GET">
                <button>Wróć do strony głównej</button>
            </form>';
    } else {
        if (isset($_POST['login'])) {
            echo '
                <h1>Nieprawidłowe dane logowania</h1>
                <form action="/as-projekt/login.php" method="GET">
                    <button>Wróć do logowania</button>
                </form>';
        } else {
            echo '
                <form method="POST">
                    <input type="hidden" name="login" value="true">
                    <input type="text" minlength=6 maxlength=15 name="username" required>
                    <label for="username">Username</label>
                    <br>
                    <input type="password" minlength=6 maxlength=16 name="password" required>
                    <label for="password">Password</label>
                    <br>
                    <button>Zaloguj</button>
                </form>
                ';
        }
    }
    ?>
</body>

</html>