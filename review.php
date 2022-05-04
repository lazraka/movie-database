<!DOCTYPE html>
<html>
<!-- when request URL contains id parameter, page must include input boxes to let user input their name, rating of movie and comment on movie
when request contains mid, name, rating, and comment parameteres, you must insert row to Review table with the provided values, value for time column should be the time when the review is submitted, returned page must display "confirmation text" -->
<body>

<h1>Review Page</h1>

<h2>Add new review here:</h2>

<?php
//connect php to sql

$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) {
	die('Unable to connect to database [' . $db->connect_error . ']');
}
$param = $_GET["id"];
if (isset($param)) {
	$param_full = 'id='.$param.";";
	$query = "SELECT * FROM Movie WHERE ".$param_full;
	$rs = $db->query($query);
	if (!$rs) {
		$errormsg = $db->error;
		print 'Query failed: $errormsg <br>';
		exit(1);
	}
	if ($rs->num_rows > 0) {
		echo "
			<h3>Movie Title:</h3>";
			while ($row = $rs->fetch_assoc()) {
				echo "<h3>".$row['title']." (".$row['year'].")</h3><br>";
				break;
			}
	} else {
		print "No results found<br>";
	}
}

?>
<form method="post">
	<label>Your Name</label>
	<input type="text" name="name" class="new-item" placeholder="Name..."/>
	<br>
	<label>Rating: </label>
	<select name="menu">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
	</select>
	<br>
	<textarea type="text" name="review" placeholder="Add review here..." rows="10" cols="30"></textarea>
	<br>
	<input type="submit" name="submit" />
</form>

<?php

$param2 = $_POST["submit"];
if (isset($param2)) {
	$param_full = "('".$_POST["name"]."', '".date('Y-m-d H:i:s')."', ".$param.", ".$_POST["menu"].", '".$_POST["review"]."');";
	$query = "INSERT INTO Review VALUES ".$param_full;
	$rs = $db->query($query);
	if (!$rs) {
		$errormsg = $db->error;
		print 'Query failed: $errormsg <br>';
		exit(1);
	}
}
$db->close()

?>

</body>
</html>