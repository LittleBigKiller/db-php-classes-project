<?php
$conn = @new mysqli('localhost', 'root', '', 'jdyrcz');

if ($conn->connect_errno) die ('Brak połączenia');

if (isset($_GET['akcja'])) {
	switch ($_GET['akcja']) {
		case 'Zad3':
			$rs = $conn -> query('SELECT imie,nazwisko
			FROM auta
			INNER JOIN osoby
			ON auta.id_wlasciciela = osoby.id_wlasciciela
			GROUP BY osoby.id_wlasciciela
			HAVING COUNT(osoby.id_wlasciciela) > 1')
				or die('Błąd pobierania danych');
				
			if ($rs -> num_rows > 0) {
				echo '<table border=1><tr><th>Imie</th><th>Nazwisko</th></tr>';
				while ($rec = $rs->fetch_array()) {
					echo "<form><td>".$rec["imie"]."</td>
					<td>".$rec["nazwisko"]."</td>
					</tr></form>";
				}
				echo '</table>';
			}
			$rs->close();
			break;
		case 'Zad4':
			$rs = $conn -> query('SELECT imie, nazwisko
				FROM
					auta
				INNER JOIN osoby ON auta.id_wlasciciela = osoby.id_wlasciciela
				WHERE
					marka = "citroen"
				ORDER BY
					auta.rok_produkcji
				LIMIT 1')
				or die('Błąd pobierania danych');
				
			if ($rs -> num_rows > 0) {
				echo '<table border=1><tr><th>Imie</th><th>Nazwisko</th></tr>';
				while ($rec = $rs->fetch_array()) {
					echo "<form><td>".$rec["imie"]."</td>
					<td>".$rec["nazwisko"]."</td>
					</tr></form>";
				}
				echo '</table>';
			}
			$rs->close();
			break;
		case 'Zad5':
			$rs = $conn -> query('UPDATE auta
				SET
					id_wlasciciela = (
					SELECT
						id_wlasciciela
					FROM
						osoby
					WHERE
						nazwisko = "Hubicki" AND imie = "Karol"
					)
				WHERE
					nr_rejestracyjny = "KR21004"');
			
			break;
	}
}


$conn->close();

echo '
<h4>Łącza:</h4>
<a href="?akcja=Zad3">Zad3</a>
<a href="?akcja=Zad4">Zad4</a>
<a href="?akcja=Zad5">Zad5</a>
';
?>