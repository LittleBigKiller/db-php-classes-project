<form method="GET">
Podaj PESEL: <input type="text" name="tekst"><br>
<input type="submit" value="Sprawdź">
</form>
<?php
	if(isset($_GET['tekst']))
	{
		$t=trim($_GET['tekst']);
		
		// Nie skończona suma kontrolna
		//$kontr = (int)$t[0] + 3 * (int)$t[1] + 7 * (int)$t[2] + 1 * (int)$t[3] + 7 * (int)$t[4]
		
		if (true) {
			echo "Data urodzenia:<br>";
			echo $t[4].$t[5]." ";
			
			
			switch ( (int)($t[2].$t[3]) % 20 ) {
				case 1:
					echo " sty ";
					break;
				case 2:
					echo " lut ";
					break;
				case 3:
					echo " mar ";
					break;
				case 4:
					echo " kwi ";
					break;
				case 5:
					echo " maj ";
					break;
				case 6:
					echo " cze ";
					break;
				case 7:
					echo " lip ";
					break;
				case 8:
					echo " sie ";
					break;
				case 9:
					echo " wrz ";
					break;
				case 10:
					echo " paź ";
					break;
				case 11:
					echo " lis ";
					break;
				case 12:
					echo " gru ";
					break;
			}
			
			switch ( (int) floor(($t[2].$t[3]) / 20) ) {
				case 0:
					echo "19";
					break;
				case 1:
					echo "20";
					break;
				case 2:
					echo "21";
					break;
				case 3:
					echo "22";
					break;
				case 4:
					echo "18";
					break;
			}
			echo $t[0].$t[1]."<br>"."<br>";
			
			echo "Płeć:<br>";
			if ( ((int) ($t[9]) % 2) == 0) {
				echo "Kobieta";
			} else {
				echo "Mężczyzna";
			}
		}
	}
?>