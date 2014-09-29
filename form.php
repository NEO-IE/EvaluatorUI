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

Heurisitc: 
<select name="Heuristic">
<option value="1">Vanilla Matching</option>
<option value="2">Distance Based Matching</option>
<option value="3">Unit Based, Exact Matching</option>
<option value="4">Unit Based, Distance Based Matching</option>
</select>

<br>
<input type="submit" name="submit" value="Submit">



</center>
</form>

</body>
</html> 
