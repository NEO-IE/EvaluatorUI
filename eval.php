<?php
if(isset($_SESSION['reloaded']) && isset($_SESSION['count'])) {
    //code to insert into database	
	//insertToDb($_SESSION['dbhandle'], $_SESSION['matches'][$_SESSION['index']], $_POST['valid'], 1);

    $_SESSION['index'] = $_SESSION['index'] + 1;
    if($_SESSION['index'] >= $_SESSION['count']) { //done with the matches
        $_SESSION['index'] = 0;
	    //mysqli_close($_SESSION['dbhandle']);	//closing the connection.	
        session_destroy();
        echo "Ok bye.";
        return;
    }
} else {
    echo "setting again<br/>";
    session_start();
	$username = "aman";
	$password = "";
	$hostname = "localhost";
	//$db = "test";
	//connection to the database
	//$dbhandle = mysqli_connect($hostname, $username, $password, $db)
  	//	or die("Unable to connect to MySQL");
	//$_SESSION['dbhandle'] = $dbhandle;
    $_SESSION['reloaded']=1;
    $file = "sampledMatches.tsv";
    $_SESSION['matches'] = file($file);
    $_SESSION['count'] = count($_SESSION['matches']);
    $_SESSION['index'] = 0;
}
if(isset($_SESSION['reloaded']) && isset($_SESSION['count'])) {
    echo "Set now here<br/>";
}
 
echo "Index : ".$_SESSION['index'];
$matchSplit = explode("\t", $_SESSION['matches'][$_SESSION['index']]);
$countryName = $matchSplit[4];
$number = $matchSplit[5];
$relation = $matchSplit[10];
$sentence = $matchSplit[11];
?>
<?php echo "<br/>".$sentence."<br/>".$countryName." ".$number." ".$relation."<br/>"; ?>
<html>
<body>
<form role = 'form' method = 'post' action = 'eval.php'>
<div class = 'form-group'>
<div class = 'checkbox'>
<label class="radio-inline">
  <input type="radio" name="valid" id="inlineRadio1" value="true"> Yes
</label>
<label class="radio-inline">
  <input type="radio" name="valid" id="inlineRadio2" value="false"> No
</label>
<input type='submit' name='submit' value='Next'>
</div>
</div>
</form>

</div>
</body>
</html>
