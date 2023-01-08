<?php
	session_start();
	require_once "pdo.php";

	//If the user is not yet logged in, this will display to on the screen to prompt the user to login
	if (! isset($_SESSION['email'])) {
	echo'<h1>Welcome to Peter\'s Automobiles</h1>';
	die('<a href="login.php">Please Log in</a>');
	}

	$oldmake = isset($_POST['make']) ? $_POST['make'] : '';
	$oldmodel = isset($_POST['model']) ? $_POST['model'] : '';
	$oldyear = isset($_POST['year']) ? $_POST['year'] : '';
	$oldmiles = isset($_POST['mileage']) ? $_POST['mileage'] : '';

	if (! isset($_SESSION['email'])) {
		die('Not logged in');
	}

	if ( isset($_SESSION["error"])){

		echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
		unset($_SESSION["error"]);
	}


	if (! isset($_POST['make']) && isset($_POST['mileage'])
		&& isset($_POST['year'])){
		$_SESSION["error"] = "Make is required";
		header('Location: add.php');
		return;
	}



	if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])
		&& isset($_POST['mileage'])){

		if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {
			$_SESSION["error"] = "All fields are required";
			header('Location: add.php');
			return;
		} 
		
		if (! is_numeric($_POST['mileage']) || ! is_numeric($_POST['year'])) {
		$_SESSION["error"]= "Mileage and year must be numeric";
		header('Location: add.php');
		return;
		}
		if (strlen($_POST['make']) < 1 ) {
			$_SESSION["error"] = "Make required";
			header('Location: add.php');
			return;
		}
		else {
			$stmt = $pdo->prepare('INSERT INTO autos
							(make, model, year, mileage) VALUES (:mk, :mo, :yr, :mi)');
			$stmt->execute(array(
				':mk' => htmlentities($_POST['make']),			
				':mo' => htmlentities($_POST['model']),			
				':yr' => htmlentities($_POST['year']),
				':mi' => htmlentities($_POST['mileage'])
			));
			$_SESSION["success"]= "Record added";
			header('Location: index.php');
			return;
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Peter Mwansa</title>
</head>
<body>
	<h1>Autos Database</h1>
	<?php
	if ( isset($_REQUEST['name']) ) {
		echo "<p>Welcome: ";
		echo htmlentities($_REQUEST['name']);
		echo "</p>\n";
	}
	?>
	<form method="post">
		<p>Add a new automobile</p>
		<p>Make:
		<input type="text" name="make" size="40" value="<?= htmlentities($oldmake)?>"></p>      <!-- All the data has been escaped used the hmtlentities  -->
        <p>Model:
		<input type="text" name="model" size="40" value="<?= htmlentities($oldmodel)?>"></p>  <!-- All the data has been escaped used the hmtlentities  -->
		<p>Mileage:
		<input type="text" name="year" value="<?= htmlentities($oldyear)?>"></p>      <!-- All the data has been escaped used the hmtlentities  -->
		<p>Year:
		<input type="text" name="mileage" value="<?= htmlentities($oldmiles)?>"></p>        <!-- All the data has been escaped used the hmtlentities  -->

		<input type="submit" value="Add">
	</form>
	<form method="post">
		<?php

		if ( isset($_POST['cancel'])){
			header('Location: index.php');
			return;
		}
		?>
		<input type="submit" name="cancel" value="cancel">
	</form>
</body>
</html>

</html>


