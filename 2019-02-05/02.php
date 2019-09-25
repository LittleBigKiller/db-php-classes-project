<?php
	if(isset($_GET['text1'], $_GET['text2'])) {
		// zmienna globalna GET (globalne zapisywane dużymi literami)
		echo($_GET['text1']."<br>".$_GET['text2']); // wywołanie konkretnych pól
	}
?>