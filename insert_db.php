<?php
//ashish
function insertToDB($response){

	$file = $_SESSION['file'];
	$matchSplit = explode("\t", $_SESSION['matches'][$_SESSION['index']]);
	$username = "aman";
	$password = "";
	$hostname = "localhost";
	$db = "test";
	
	$dbhandle = new mysqli($hostname, $username, $password, $db)
  		or die("Unable to connect to MySQL");
	
	$sentenceID = $matchSplit[6];
	$countryName = $matchSplit[0];
	$st_offset = $matchSplit[4];
	$end_offset = $matchSplit[5];
	$number = $matchSplit[3];
	$relation = $matchSplit[7];
	$sentence = addslashes($matchSplit[9]);

	$sql = "select * from SentenceMatcher where SENTID = '$sentenceID' and Country = '$countryName' and st_offset = $st_offset and end_offset = $end_offset and relation = '$relation' and evaluation_file = '$file';";
    
	if ($result = $dbhandle->query($sql))
    	{
//	       	echo "Fetching results<br/>";
        
  		$row=mysqli_fetch_row($result);
//        	print_r($row);
  		mysqli_free_result($result);
	}		

	if( empty($row)){   	//insert into db
	       // echo "Found empty, initializing by insertion<br/>";
		
		$insert_str = "Insert into SentenceMatcher values('','$sentenceID', '$countryName', $st_offset, $end_offset, '$number',  '$relation', '$sentence', '$file', '$response');";

		if($response == "true"){
			$_SESSION['trueCount'] = $_SESSION['trueCount'] + 1;
		}

//        	echo $insert_str . "<br>";

        	$result = $dbhandle->query($insert_str);
        	if (!$result) {
            		trigger_error('Invalid query: ' . mysql_error());
        	}
	}else{			//update into db
		$ID = $row[0];
		$old_response = $row[9];
		
		$update_str = "Update SentenceMatcher set response = '$response' where ID = $ID;";

		if(($old_response == 'false' || $old_response == '' ) && $response == 'true'){
			$_SESSION['trueCount'] = $_SESSION['trueCount'] + 1;
		}else if($old_response == 'true' && $response == 'false'){
			$_SESSION['trueCount'] = $_SESSION['trueCount'] - 1;
		}

 //       	echo $update_str . "<br>";

		$result = $dbhandle->query($update_str);	
		 if (!$result) {
                        trigger_error('Invalid query: ' . mysql_error());
                }
	}		
	$dbhandle->close();
}
?>
