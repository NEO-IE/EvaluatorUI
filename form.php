<html>
<title> Evaluator </title>
<body>


<form action="eval.php" method="post" enctype="multipart/form-data">

<center>
<head> <h3> Extractor Evaluator </h3> </head>

Upload the evaluation file: <input type="file" name="file" id="file">

<!--
File: <select name="file">
<?php /*
    $files = scandir("upload");
    for($i = 2; $i < count($files); $i += 1){
        echo "<option value=\"". $files[$i]. "\"> ".$files[$i]. "</option>";
    }
	*/
?>
</select>
-->
<br>
<br>
<input type="submit" name="submit" value="Submit">



</center>
</form>

</body>
</html> 
