<?php

if ($_FILES["file"]["error"] > 0) {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {
	//sg
	if( !isset( $_SESSION ) ) {
	//session_destroy();
		session_start();

	        $username = "aman";
        	$password = "";
        	$hostname = "localhost";
        	$db = "test";
        	//connection to the database
        	$dbhandle = mysqli_connect($hostname, $username, $password, $db)
                	or die("Unable to connect to MySQL");
        	$_SESSION['dbhandle'] = $dbhandle;

		$_SESSION['Heuristic'] = $_POST['Heuristic'];
		$file = $_FILES["file"]["name"];

        move_uploaded_file($file, "upload/".$file);
        $_SESSION['file']  = "upload/" . $file;

		header("Location: eval.php");


	}
}
?>
