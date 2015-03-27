<html>
<title> Evaluator </title>
<body>


<form action="eval.php" method="post">

<center>
<head> <h3> Extractor Evaluator </h3> </head>

File: <select name="file">
<?php
    $files = scandir("upload");
    for($i = 2; $i < count($files); $i += 1){
        echo "<option value=\"". $files[$i]. "\"> ".$files[$i]. "</option>";
    }
?>
</select>
<br>
<input type="submit" name="submit" value="Submit">



</center>
</form>

</body>
</html> 
