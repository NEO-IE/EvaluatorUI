<?php
include 'insert_db.php';
if(!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['reloaded']) && isset($_SESSION['count'])) {
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
<div class = "container">
<table class = "table table-bordered" border = "1px">
<tr>
<td><?php echo "$sentence"; ?></td>
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
</form>
<span id = "tick"></span>
</div>
</div>
<span style = "float:right" class="glyphicon glyphicon-search"></span>
<span style = "float:left" class="glyphicon glyphicon-search"></span>
</body>
</html>
