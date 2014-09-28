<?php
include 'insert_db.php';
if(!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['reloaded']) && isset($_SESSION['count'])) {
    //code to insert into database	
	insertToDb($_SESSION['dbhandle'], $_SESSION['matches'][$_SESSION['index']], $_POST['valid'], 1);
    if($_POST['direction'] == 1) { //right
        $_SESSION['index'] = $_SESSION['index'] + 1;
    } else {
        $_SESSION['index'] = ($_SESSION['index'] == 0) ? 0 : $_SESSION['index'] - 1;
    }
    if($_SESSION['index'] >= $_SESSION['count']) { //done with the matches
        $_SESSION['index'] = 0;
	    mysqli_close($_SESSION['dbhandle']);	//closing the connection.	
        session_destroy();
        echo "Ok bye.";
        return;
    }
} else {
	$username = "aman";
	$password = "";
	$hostname = "localhost";
	//$db = "test";
	//connection to the database
	$dbhandle = mysqli_connect($hostname, $username, $password, $db)
  		or die("Unable to connect to MySQL");
	$_SESSION['dbhandle'] = $dbhandle;
    $_SESSION['reloaded']=1;
    $file = "sampledMatches.tsv";
    $_SESSION['matches'] = file($file);
    $_SESSION['count'] = count($_SESSION['matches']);
    $_SESSION['index'] = 0;
}
 
$matchSplit = explode("\t", $_SESSION['matches'][$_SESSION['index']]);
$countryName = $matchSplit[4];
$number = $matchSplit[5];
$relation = $matchSplit[10];
$sentence = $matchSplit[11];
$startOff = $matchSplit[6];
$endOff = $matchSplit[7];
$l = strlen($sentence);
$annonSent = "";
for($i = 0; $i < $l; $i++) {
    if($i == $startOff) {
        $annonSent = $annonSent . "<mark  style='background-color:yellow;'>";
    } else if($i == $endOff) {
        $annonSent = $annonSent . "</mark>";
    }
    $annonSent = $annonSent . $sentence[$i];
}

?>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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
