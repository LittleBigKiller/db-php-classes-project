<?php
    $conn = mysqli_connect('localhost', 'root', '', 'mysql');
    if (!$conn) die('Brak połączenia z serwerem');

    $sql='SELECT Host, User FROM user';
    //echo $sql;
    $rs = mysqli_query($conn, $sql);

    if (mysqli_num_rows($rs) > 0) {
        $rec = mysqli_fetch_array($rs);
        echo $rec[1].'@'.$rec['Host'];  // zgodność w zapytaniu i wyświetlaniu
    }
?>