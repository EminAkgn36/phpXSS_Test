<?php
	
	// Create a database, create a table then insert the data
	$db = new PDO('sqlite:templateDatabase.db');
	$db->exec("PRAGMA encoding = \"UTF-8\";");
	$db->exec("CREATE TABLE IF NOT EXISTS Users(userID int Primary Key, name varchar(50) UNIQUE, password text);");
	$db->exec("INSERT OR IGNORE INTO Users Values (1,'Root','555554444'),(2,'Guest','444448888');");

	
	// Required for print the errors
	$errors = array('userName' => '', 'password' => '');

	if(isset($_POST['submit'])){
		
		// These 2 are required for control of the inputs 
		$checkUsrName = false;
		$checkPass = false;

		$check = $db->query("SELECT (SELECT count(userID) FROM Users Where Users.name = '". $_POST['name'] ."') as usrName;");
		$response = $check->fetchAll();

		if(empty($_POST['name']))
			$errors['userName'] = 'User name is required!'; 

		else if($response[0]['usrName'] != 0)
			$errors['userName'] = 'User name is taken! Choose another!';	
		
		if(empty($_POST['password']))
			$errors['password'] = 'Password is required';
	

		if(!array_filter($errors)){
			$errors['password'] = "";	
			$checkUsrName = true;
			$checkPass = true;
		}
	
	}

?>



<!DOCTYPE html>
<html>
	<?php include('templates/headers.php'); ?>

	<form action="storedXss.php" method="POST">
		<label>Username:</label><br>
		<input type="text" name="name">
		<h3><?php echo $errors['userName'] ?></h3><br>
		<label>Password:</label><br>
		<input type="text" name="password">
		<h3><?php echo $errors['password'] ?></h3><br>
		<input type="submit" name="submit" value="Add Informations">
		<input type="submit" name="showDB" value="Show Table">
		<input type="submit" name="returnHomePage" value="Return Home Page">
		
	</form>

	<?php include('templates/footer.php'); ?>
</html>




<?php

	global $db;

	// Generates an ID 3 and 1500. IDs are different from each other
	function idMaker()
	{
		$id = 0;

		do{
			global $db;

			$id = mt_rand(3,1500);
			
			// Is that ID exist? If yes, Generate Again		
			$check = $db->query("SELECT (SELECT count(userID) FROM Users Where Users.userID = ". $id .") as numID;");
			$response = $check->fetchAll();

		}while($response[0]['numID']);
		
		return $id;
	}


	// Print the SQL Query result
	function databasePrint(&$result)
	{
		print("<table border=2>");
		print("<tr><td> User ID </td><td> User Name </td><td> Password </td>");
	
		foreach($result as $row){
			print "<tr><td> ".$row['userID']."</td>";
			print "<td> ".$row['name']."</td>";
			print "<td> ".$row['password']."</td></tr>";
		}
	}
	

	$result = $db->query("SELECT * FROM Users;");

	if(isset($_POST['submit'])){

		if($checkUsrName and $checkPass)
		{
			echo "<br><br>";
	

			$id = idMaker();

			$name = $_POST['name'];

			str_replace("\"", "\\\"", $_POST['name']);
			str_replace("\"", "\\\"", $_POST['password']);


			$db->exec("INSERT INTO Users Values (" . $id . ", '" . $_POST['name'] . "', '". $_POST['password'] ."'); ");
		

			databasePrint($result);
		
			$db=null;
		}
	}
	elseif(isset($_POST['returnHomePage']))
	{
		$db=null;
		header("Location: index.php");
	}
	elseif(isset($_POST['showDB']))
	{

		$db=null;
		print_r("<br></br>");
		databasePrint($result);
	}


	
