<form method="GET">
Podaj Tekst: <input type="text" name="tekst"><br>
<input type="submit" value="Szyfruj">
</form>
<?php
	if(isset($_GET['tekst']))
	{
		$t = trim($_GET['tekst']);
		for($i = 0; $i < strlen($t); $i++)
		{
			if ($t[$i] == 'K') $t[$i] = 'O';
			elseif ($t[$i] == 'O') $t[$i] = 'K';
			elseif ($t[$i] == 'N') $t[$i] = 'I';
			elseif ($t[$i] == 'I') $t[$i] = 'N';
			elseif ($t[$i] == 'E') $t[$i] = 'C';
			elseif ($t[$i] == 'C') $t[$i] = 'E';
			elseif ($t[$i] == 'M') $t[$i] = 'A';
			elseif ($t[$i] == 'A') $t[$i] = 'M';
			elseif ($t[$i] == 'T') $t[$i] = 'U';
			elseif ($t[$i] == 'U') $t[$i] = 'T';
			elseif ($t[$i] == 'R') $t[$i] = 'Y';
			elseif ($t[$i] == 'Y') $t[$i] = 'R';
		}
		echo $t;
	}
?>