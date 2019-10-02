<?php
	echo '<a href="?zad=3">Zadanie 3</a><br>
		<a href="?zad=4">Zadanie 4</a><br>
		<a href="?zad=5">Zadanie 5</a><br>';
	if(isset($_GET['zad']))
	{
		$conn=new mysqli('localhost','mnowak','mnowak','mnowak');
		if(!$conn) exit('Błąd połączenia');
		switch($_GET['zad'])
		{
			case 3:
				$sql='SELECT imie,nazwisko FROM osoby o INNER JOIN auta a ON o.pesel=a.pesel
					GROUP BY o.pesel HAVING Count(nr)>1';
				$rs=$conn->query($sql) or die('Nie można pobrać rekordów');
				if($rs->num_rows>0)
				{
					echo '<p><b>Zadanie 3</b></p>';
					echo '<table border=1><tr><th>Imię</th><th>Nazwisko</th></tr>';
					while($rec=$rs->fetch_array())
					{
						echo '<tr><td>'.$rec['imie'].'</td><td>'.$rec['nazwisko'].'</td></tr>';
					}	
					echo "</table>";
				}
				else
					echo 'Brak rekordów';
				break;
			case 4:
				$sql="SELECT imie,nazwisko FROM osoby o INNER JOIN auta a ON o.pesel=a.pesel
					WHERE marka='Citroen' ORDER BY rok LIMIT 1";
				$rs=$conn->query($sql) or die('Nie można pobrać rekordów');
				if($rs->num_rows>0)
				{
					echo '<p><b>Zadanie 4</b></p>';
					echo '<table border=1><tr><th>Imię</th><th>Nazwisko</th></tr>';
					$rec=$rs->fetch_array();
					echo '<tr><td>'.$rec['imie'].'</td><td>'.$rec['nazwisko'].'</td></tr>';	
					echo "</table>";
				}
				else
					echo 'Brak rekordów';
				break;			
				break;
			case 5:
				$sql="UPDATE auta a,osoby o SET a.pesel=o.pesel WHERE imie='Karol' AND nazwisko='Hubicki' AND nr='KR21004'";
				if($conn->query($sql)===TRUE)
					echo '<br><b>Zadanie 5</b><br><br>Zaktualizowano rekordów: '.$conn->affected_rows.'<br>';
				else
					echo 'Nie można zaktualizować rekordów<br>';
				break;
		}
		$conn->close();
	}
?>