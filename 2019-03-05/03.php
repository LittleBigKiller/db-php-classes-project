<form method="GET">
Podaj Tekst: <input type="text" name="tekst"><br>
<input type="submit" value="Szyfruj">
</form>
<?php
	if(isset($_GET['tekst']))
	{
        $t = trim($_GET['tekst']);

        $delims = [];

        for ($i = 0; $i < strlen($t); $i++)
            if ($t[$i] == ' ')
                array_push($delims, $i);

        for ($i = 0; $i <= count($delims); $i++) {
            $temp = '';
            if ($i == 0)
                $start = 0;
            else
                $start = $delims[$i - 1] + 1;

            if ($i == count($delims))
                for ($j = $start; $j < strlen($t); $j++)
                    $temp = $temp.$t[$j];
            else
                for ($j = $start; $j < $delims[$i]; $j++)
                    $temp = $temp.$t[$j];

            if (strlen($temp) % 2 == 0)
                $temp = strrev($temp);
            echo $temp.' ';
        }
	}
?>