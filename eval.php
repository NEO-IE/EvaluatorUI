<?php

function getStartOccur($string, $word){
    $positions = array();
    $pos = -1;
    while( ($pos = strpos($string, $word, $pos+1)) != false){
        $positions[] = $pos;
    }
    return $positions;
}

include 'insert_db.php';
if(!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['reloaded']) && isset($_SESSION['count'])) {

    insertToDb($_POST['valid']);

    if($_POST['direction'] == 1) { //right
        $_SESSION['index'] = $_SESSION['index'] + 1;
    } else {
        $_SESSION['index'] = ($_SESSION['index'] == 0) ? 0 : $_SESSION['index'] - 1;
    }
    if($_SESSION['index'] >= $_SESSION['count']) { //done with the matches
        $_SESSION['index'] = 0;
//	mysqli_close($_SESSION['dbhandle']);	//closing the connection.	

	//Print precision recall here..
	$tCount = $_SESSION['trueCount'];
	echo "True Count: $tCount <br>";
	
	$precision = $_SESSION['trueCount'] / $_SESSION['count'] * 100;
	echo "Precision : $precision <br>"; 
	$recall = $_SESSION['trueCount'] / 291 * 100;
	echo "Recall : $recall <br>";
	$f1_score = ((2 * $precision * $recall) / ($precision + $recall));
	echo "F1 score: $f1_score <br>";
        session_destroy();
        echo "Ok bye.";
        return;
    }
} else {

//	$username = "aman";
//	$password = "";
//	$hostname = "localhost";
//	$db = "test";
	//connection to the database
//	$dbhandle = new mysqli($hostname, $username, $password, $db)
// 		or die("Unable to connect to MySQL");
//	$_SESSION['dbhandle'] = $dbhandle;

	$target_dir = "upload/";
	$target_file = $target_dir . basename ($_FILES["file"]["name"]);

	if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        	echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
    	} else {
        	echo "Sorry, there was an error uploading your file.";
		return;
    	}

    	$_SESSION['reloaded']=1;
	$_SESSION['file'] = basename($_FILES["file"]["name"]);
    	$_SESSION['matches'] = file($target_file);
    	$_SESSION['count'] = count($_SESSION['matches']);
	$count = $_SESSION['count'];
    	$_SESSION['index'] = 0;
	$_SESSION['trueCount'] = 0;
}
 
$matchSplit = explode("\t", $_SESSION['matches'][$_SESSION['index']]);
$countryName = $matchSplit[0];
$number = $matchSplit[3];
$relation = $matchSplit[7];
$sentence = $matchSplit[9];
$startOff = $matchSplit[4];
$endOff = $matchSplit[5];
$l = strlen($sentence);

$positions = getStartOccur($sentence, $countryName);
$posCount = count($positions);
$wordlen = strlen($countryName);

$annonSent = "";
$posCtr = 0;
for($i = 0; $i < $l; $i++) {
    if($i == $startOff) {
        $annonSent = $annonSent . "<mark  style='background-color:yellow;'>";
    } else if($i == $endOff) {
        $annonSent = $annonSent . "</mark>";
    }if($posCtr < $posCount && $i == $positions[$posCtr]){
        $annonSent = $annonSent . "<mark style='background-color:blue;'>";
    }else if($posCtr < $posCount && $i == ($positions[$posCtr] + $wordlen)){
        $posCtr += 1;
        $annonSent = $annonSent . "</mark>";
    }
    $annonSent = $annonSent . $sentence[$i];
}

?>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<script src="js_css/jquery-1.10.1.min.js"></script>
<!-- Latest compiled and minified CSS 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
-->
<link rel="stylesheet" href="js_css/bootstrap.min.css">

<!-- Optional theme 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
-->
<link rel="stylesheet" href="js_css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="js_css/bootstrap.min.js"></script>
<script src = "kb.js"></script>
</head>
<body>
<div class="progress">
<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $_SESSION['index']; ?>" aria-valuemin="1" aria-valuemax="<?php echo $_SESSION['count']; ?>" style= "width: <?php echo ($_SESSION['index'] / $_SESSION['count']) * 100 ?>%;">
<?php $curr = $_SESSION['index'] + 1;echo $curr. " / ". $_SESSION['count']." done"; ?>
  </div>
</div>

<img src = "imgs/right.png"  style = "float:right;margin-top:80px"/>
<img src = "imgs/left.png " style = "float:left;margin-top:80px"/>
<div class = "container" style = "margin-top:150px">
<table class = "table table-bordered" border = "1px" style>
<tr>
<td><?php echo "$annonSent"; ?></td>
</tr>
</table >
<table class = "table" border = "1px" cellspacing = "3px" cellpadding = "4px">
<tr class = "active">
<td width = "30%"><?php echo $countryName; ?></td>
<td width = "30%"><?php echo " ".$number." "; ?> </td>
<td width = "30%"><?php echo "$relation.<br/>"; ?></td>
</tr>
</table>

<form id = "qtn" name = "qtn" role = 'form' method = 'post' action = 'eval.php'>
<input type='hidden' id = "valid" name = 'valid'/>
<input type='hidden' id = "direction" value = "1" name = 'direction'/>
</form>
</div>
</div>
<center><img id = "verdict" src = "imgs/equal.jpg" height = "42" /></center>

</body>
</html>
