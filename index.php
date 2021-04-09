

<!DOCTYPE html>
<html>
	<?php include('templates/headers.php'); ?>

	<form action="index.php" method="POST">
		<h3>Chose your choice:</h3>
		<input type="radio" name="choose" value="XSS" > XSS
		<input type="radio" name="choose" value="Stored XSS" > Stored XSS
		<br><br>
		<input type="submit" name="entered" value="Entered">
	</form>

	<?php include('templates/footer.php'); ?>
</html>




<?php
	
	error_reporting(0);

	if(isset($_POST['entered']))
	{
		echo "<br><br>";

		switch($_POST['choose'])
		{
			case "XSS":
				header("Location: Xss.php");
				$errorStr = "";
				break;

			case "Stored XSS":
				header("Location: storedXss.php");
				break;
			
			default:
				print_r("<h3>Choose one of them please</h3>");
				break;

		}
	}	

?>