<?php
require_once "pdo.php";

session_start();

//If the user is not yet logged in, this will display to on the screen to prompt the user to login
if (! isset($_SESSION['email'])) {
echo'<h1>Welcome to Peter Mwansa Automobiles</h1>';
  die('<a href="login.php">Please log in</a>');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Peter Mwansa Index Page</title>
	<?php require_once "bootstrap.php"; ?>
</head>

<body>
    <?php
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    if ( isset($_SESSION['success']) ) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }



    echo'<h1>Peter Mwansa\'s Automobiles</h1>';
    echo('<table border="1">'."\n");
    $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

        echo "<tr><td>";
        echo(htmlentities($row['make']));
        echo("</td><td>");
        echo(htmlentities($row['model']));
        echo("</td><td>");
        echo(htmlentities($row['year']));
        echo("</td><td>");
        echo(htmlentities($row['mileage']));
        echo("</td><td>");


        echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
        echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
        echo("</td></tr>\n");
    }
    ?>
    </table>
    <div>
        <br>
    </div>
    <a href="add.php">Add New Entry</a>
    <a href="logout.php">Logout</a>
</body>

</html>
