<form method='GET' action='04.php'>
	<input type='number' name='n1' min='0' max='9223372036854775807' step='1' required><br>
	<select name='f' required>
		<option value='+'>+</option>
		<option value='-'>-</option>
		<option value='*'>*</option>
		<option value='/'>/</option>
	</select><br>
	<input type='number' name='n2' min='0' max='9223372036854775807' step='1' required><br>
	<input type='submit' value='Przelicz'><br>
</form>