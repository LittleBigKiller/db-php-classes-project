<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>

<body>
    <?php
    include('dbcredentials.php');
    $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

    if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

    if (isset($_POST['register'])) {
        $rs = $conn->query('SELECT `users`.`username` FROM `users` WHERE `username` = "' . $_POST['username'] . '"')
            or die('Błąd pobierania danych');

        if ($rs->num_rows == 0) {
            $perms = 0;
            if ($_POST['isAdmin'] == 'on') $perms = 1;

            $rs = $conn->query('INSERT INTO `users`(`username`, `password`, `perm_level`) VALUES ("' . $_POST['username'] . '", "' . md5($_POST['password']) . '",' . $perms . ')')
                or die('<h1>Błąd rejestracji</h1>
                    <form action="/as-projekt/" method="GET">
                        <button>Wróć do strony głównej</button>
                    </form>');

            echo '
            <h1>Zarejestrowano użytkownika: ' . $_POST['username'] . '</h1>
            <form action="/as-projekt/" method="GET">
                <button>Wróć do strony głównej</button>
            </form>
            <form action="/as-projekt/login.php" method="GET">
                <button>Zaloguj się</button>
            </form>';
        } else {
            echo '
            <h1>Użytkownik istnieje</h1>
            <form action="/as-projekt/" method="GET">
                <button>Wróć do strony głównej</button>
            </form>
            <form action="/as-projekt/register.php" method="GET">
                <button>Wróć do rejestracji</button>
            </form>';
        }
    } else {
        echo '
            <form method="POST">
                <input type="hidden" name="register" value="true">
                <input type="text" minlength=6 maxlength=15 name="username" required>
                <label for="username">Username</label>
                <br>
                <input type="password" minlength=6 maxlength=16 name="password" required>
                <label for="password">Password</label>
                <br>
                <input type="checkbox" name="isAdmin">
                <label for="isAdmin">isAdmin</label>
                <br>
                <button>Zarejestruj</button>
            </form>
            <form action="/as-projekt/" method="GET">
                <button>Wróć do strony głównej</button>
            </form>
            ';
    }
    ?>


</body>

</html>