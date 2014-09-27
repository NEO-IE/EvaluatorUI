<html>
<body>
<?php

//ashish
function insertToDB($dbhandle, $String, $response, $Heuristic){

	$matchSplit = explode("\t", $_SESSION['matches'][$_SESSION['index']]);
	
	$sentenceID = $matchSplit[0];
	$countryName = $matchSplit[4];
	$st_offset = $matchSplit[6];
	$end_offset = $matchSplit[7];
	$number = $matchSplit[5];
	$relation = $matchSplit[10];
	$sentence = addslashes($matchSplit[11]);

	$sql = "select * from SentenceMatcher where SENTID = '$sentenceID' and 
				Country = '$countryName' and st_offset = $st_offset and end_offset = $end_offset
				and relation = '$relation';";
		
	$row = array();
	if ($result=mysqli_query($dbhandle,$sql))
  	{
  		// Fetch one and one row
  		$row=mysqli_fetch_row($result);

  		mysqli_free_result($result);
	}		
	
	if( empty($row)){   	//insert into db
		
		$insert_str = "Insert into SentenceMatcher values('','$sentenceID', '$countryName', $st_offset, $end_offset, $number,  
				'$relation', '$sentence', ";

		if($Heuristic == 1){
			$insert_str .= "'$response', '','',''";
		}else if($Heuristic == 2){
			$insert_str .= "'','$response','',''";
		}else if($Heuristic == 3){
			$insert_str .= "'','','$response',''";
		}else{
			$insert_str .= "'','','','$response'";
		}
		$insert_str .= ");";

		mysqli_query($dbhandle,$insert_str);


	}else{			//update into db
		$ID = $row[0];
		
		$update_str = "Update SentenceMatcher set ";
		if($Heuristic == 1){
			$update_str .= "Heuristic1 = '$response' ";
		}else if($Heuristic == 2){
			$update_str .= "Heuristic2 = '$response' ";
		}else if($Heuristic == 3){
			$update_str .= "Heuristic3 = '$response' ";
		}else{
			$update_str .= "Heuristic4 = '$response' ";
		}

		$update_str .= "where ID = $ID;";
		mysqli_query($dbhandle, $update_str);	
	}		
	

}

//sg
/* 
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
}
*/
if(isset($_SESSION['reloaded']) && isset($_SESSION['count'])) {
    echo "Previous was " . $_POST["valid"]. "<br/>";

    //code to insert into database	

	insertToDb($_SESSION['dbhandle'], $_SESSION['matches'][$_SESSION['index']], $_POST['valid'], 1);

    $_SESSION['index'] = $_SESSION['index'] + 1;

    if($_SESSION['index'] >= $_SESSION['count']) { //done with the matches
        $_SESSION['index'] = 0;

	mysqli_close($_SESSION['dbhandle']);	//closing the connection.	

        session_destroy();
        echo "Ok bye.";
        return;
    }
    //echo "Index : " + $_SESSION['index'] + "<br/>";
} else {
    $_SESSION['reloaded'] = 1;
    $file = $_SESSION['file'];
    $_SESSION['matches'] = file($file);
    $_SESSION['count'] = count($_SESSION['matches']);
    $_SESSION['index'] = 0;
    //echo "xIndex : " + $_SESSION['index'] + "<br/>";
}

$matchSplit = explode("\t", $_SESSION['matches'][$_SESSION['index']]);
$countryName = $matchSplit[4];
$number = $matchSplit[5];
$relation = $matchSplit[10];
$sentence = $matchSplit[11];
echo $sentence."<br/>".$countryName." ".$number." ".$relation."<br/>";
echo "<form method = 'post' action = eval.php>";
echo "Is Valid : Yes <input type = 'radio' name = 'valid' value = 'true'>";
echo " No <input type = 'radio' name = 'valid' value = 'false'>";
echo "<input type='submit' name='submit' value='Next'>";
echo "</form>";

?>
</body>
</html>
