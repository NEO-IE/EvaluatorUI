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
?>
