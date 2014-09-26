<html>
<body>
<?php
//sg
if( !isset( $_SESSION ) ) {
    //session_destroy();
    session_start();
}
if(isset($_SESSION['reloaded']) && isset($_SESSION['count'])) {
    $_SESSION['index'] = $_SESSION['index'] + 1;
    echo "Previous was " . $_POST["valid"]. "<br/>";
    //insert your function here
    if($_SESSION['index'] >= $_SESSION['count']) { //done with the matches
        $_SESSION['index'] = 0;
        session_destroy();
        echo "Ok bye.";
        return;
    }
    //echo "Index : " + $_SESSION['index'] + "<br/>";
} else {
    $_SESSION['reloaded'] = 1;
    $_SESSION['matches'] = file("sampledMatches.tsv");
    $_SESSION['count'] = count($_SESSION['matches']);
    $_SESSION['index'] = 1;
    //echo "xIndex : " + $_SESSION['index'] + "<br/>";
}

$matchSplit = explode("\t", $_SESSION['matches'][$_SESSION['index']]);
$countryName = $matchSplit[4];
$number = $matchSplit[5];
$relation = $matchSplit[10];
$sentence = $matchSplit[11];
echo $sentence."<br/>".$countryName." ".$number." ".$relation."<br/>";
echo "<form method = 'post' action = eval.php>";
echo "Is Valid : Yes <input type = 'radio' name = 'valid' value = 'yes'>";
echo " No <input type = 'radio' name = 'valid' value = 'no'>";
echo "<input type='submit' name='submit' value='Next'>";
echo "</form>";

?>
</body>
</html>
