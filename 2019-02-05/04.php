<?php
	if (isset( $_GET['n1'], $_GET['f'], $_GET['n2'] )) {
		$n1 = $_GET['n1'];
		$n2 = $_GET['n2'];
		$f = $_GET['f'];
		echo( $n1." ".$f." ".$n2." = " );
		switch ($f) {
			case '+':
				echo( $n1 + $n2 );
				break;
			case '-':
				echo( $n1 - $n2 );
				break;
			case '*':
				echo( $n1 * $n2 );
				break;
			case '/':
				if ( $n2 != 0 ) {
					echo( $n1 / $n2 );
				}
				else {
					echo( " nie można dzielić przez 0" );
				}
				break;
			default:
				echo("u wot?");
		}
	}
?>