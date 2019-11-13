<?php
if ($_POST['action'] == 'save') {
    include('dbcredentials.php');
    $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

    if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

    $rs = $conn->query('UPDATE `users` SET `username`="' . $_POST['username'] . '", `perm_level`="' . $_POST['perm_level'] . '" WHERE `uid`="' . $_POST['uid'] . '"')
        or die('Błędne dane');
} else if ($_POST['action'] == 'delete') {
    include('dbcredentials.php');
    $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

    if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

    $rs = $conn->query('DELETE FROM `users` WHERE `uid`="' . $_POST['uid'] . '"')
        or die('Błędne dane');
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
    if (isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
        include('dbcredentials.php');
        $conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

        if ($conn->connect_errno) die('Nie można się połączyć z bazą danych');

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

                    if ($rs->num_rows > 0) {
                        echo '
                        <table border=1>
                        <tr>
                            <th>Nazwa Użytkownika</th>
                            <th>Permisje</th>
                            <th>Akcje</th>
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
                                    </tr>
                                </form>
                                ';
                            } else {
                                $perm_text = 'użytkownik';
                                if ($rec['perm_level'] == 1) {
                                    $perm_text = 'administrator';
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

                    $rs->close();

                } else if ($_POST['submenu'] == 'questions') {
                    echo '
                        <h2> Zarządzaj pytaniami </h2>
                        ';

                } else if ($_POST['submenu'] == 'topusers') {
                    echo '
                        <h2> 10 najlepszych użytkowników </h2>
                        ';

                } else if ($_POST['submenu'] == 'topquestions') {
                    echo '
                        <h2> 10 najtrudniejszych pytań </h2>
                        ';
                        
                } else {
                    echo '
                        <h2> Zarządzaj </h2>

                        <form action="/as-projekt/adminpanel.php" method="POST">
                            <input type="hidden" name="submenu" value="users">
                            <button>Zarządzaj użytkownikami</button>
                        </form>

                        <form action="/as-projekt/adminpanel.php" method="POST">
                            <input type="hidden" name="submenu" value="questions">
                            <button>Zarządzaj pytaniami</button>
                        </form>

                        <form action="/as-projekt/adminpanel.php" method="POST">
                            <input type="hidden" name="submenu" value="topusers">
                            <button>10 najlepszych użytkowników</button>
                        </form>

                        <form action="/as-projekt/adminpanel.php" method="POST">
                            <input type="hidden" name="submenu" value="topquestions">
                            <button>10 najtrudniejszych pytań</button>
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