<?php

if ($_FILES["file"]["error"] > 0) {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {
	//sg
	if( !isset( $_SESSION ) ) {
	//session_destroy();
		session_start();

	        $username = "root";
        	$password = "";
        	$hostname = "localhost";
        	$db = "sentenceMatching";
        	//connection to the database
        	$dbhandle = mysqli_connect($hostname, $username, $password, $db)
                	or die("Unable to connect to MySQL");
        	$_SESSION['dbhandle'] = $dbhandle;

		$_SESSION['Heuristic'] = $_POST['Heuristic'];
		$_SESSION['file'] = $_FILES["file"]["tmp_name"];

		header("Location: eval.php");


	}
}
?>
