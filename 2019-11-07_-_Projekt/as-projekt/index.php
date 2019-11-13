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
</head>

<body>
    <?php
    if (isset($_COOKIE['username']) and isset($_COOKIE['password']) and !isset($_POST['logout'])) {
        include('dbcredentials.php');
        $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

        if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

        $rs = $conn->query('SELECT `perm_level` FROM `users` WHERE `username` = "' . $_COOKIE['username'] . '" AND `password` = "' . $_COOKIE['password'] . '"')
            or die('Błąd pobierania danych');

        $rec = $rs->fetch_array();

        $is_admin = false;
        if ($rec['perm_level'] == '1') {
            $is_admin = true;
        }

        echo '
            <h1> Strona główna </h1>
            <h2> Zalogowany jako: ' . $_COOKIE['username'] . ' </h2>
            <form action="/as-projekt/" method="POST">
                <input type="hidden" name="logout" value="true">
                <button>Wyloguj</button>
            </form>
            ';
        if ($is_admin) {
            echo '
            <h2> Admin Content h2 </h2>

            <form action="/as-projekt/adminpanel.php" method="GET">
                <button>Panel Administracyjny</button>
            </form>';
        } else {
            echo '
            <h2> User Content h2 </h2>
            ';
        }

        echo '
        <h2> Shared Content </h2>
        ';

        echo '
            ';
    } else {
        echo '
            <h1>Nie jesteś zalogowany</h1>
            <form action="/as-projekt/login.php" method="GET">
                <button>Zaloguj</button>
            </form>
            <form action="/as-projekt/register.php" method="GET">
                <button>Zarejestruj</button>
            </form>
            ';
    }
    ?>
</body>

</html>