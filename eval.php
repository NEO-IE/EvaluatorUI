<html>
<?php
//sg
if( !isset( $_SESSION ) ) {
    //session_destroy();
    session_start();
}
if(isset($_SESSION['reloaded']) && isset($_SESSION['count'])) {
    $_SESSION['index'] = $_SESSION['index'] + 1;
    if($_SESSION['index'] >= $_SESSION['count']) {
        $_SESSION['index'] = 0;
    }
    echo "Index : " + $_SESSION['index'] + "<br/>";
} else {
    $_SESSION['reloaded'] = 1;
    $_SESSION['matches'] = file("sampledMatches.tsv");
    $_SESSION['count'] = 10;//count($_SESSION['matches']);
    echo $_SESSION['count'];
    $_SESSION['index'] = 1;
    echo "xIndex : " + $_SESSION['index'] + "<br/>";
}

print_r($_SESSION['matches'][$_SESSION['index']]);
?>
</html>
