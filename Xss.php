<?php
	
	// Require for checking "print" that is in the form
	$checkPrint = false;
	$strPrintError = "";

	if(isset($_POST['print']))
	{
		if(!empty($_POST['txt']))
		{
			$checkPrint = true;
			$strPrintError = "";
		}
		else
		{
			$checkPrint = false;
			$strPrintError = "A string is required!";
		}
	}

?>



<!DOCTYPE html>
<html>
	<?php include('templates/headers.php'); ?>

	<form action="Xss.php" method="POST">
		<label>Enter something: </label>
		<input type="text" name="txt">
		<input type="submit" name="print" value="Print">
		<input type="submit" name="returnHome" value="Return Home Page">
		<h3><?php echo $strPrintError ?></h3> 
	</form>

	<?php include('templates/footer.php'); ?>
</html>

<?php 
	echo "<br>";

	if(isset($_POST['print'])){
	
		if($checkPrint)
		{	
			print("User Entered: ");
			print($_POST['txt']);
		}
	}
	
	elseif(isset($_POST['returnHome']))
	{
		header("Location: index.php");
	}


