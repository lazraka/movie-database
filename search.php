<!DOCTYPE html>
<html>
<!-- page that lets users search for actor/movie through keyword search interface
if keywords provided as actor parameter of URL, page must return list of actors who first or last name contains keywords, clicking on each movie must lead to corresponding actor page
if keywords provided as movie parameter of URL, page must return the list of movies whose title contains keywords, clicking on each actor must lead to corresponding movie page
search page should support multi-word search and be case insensitive -->

<head>
	<title>Search Page</title>
	<meta name="description" content="Search Page for database"/>
</head>

<body>
	<header>
		<h1>Searching Page:</h1>
	</header>
	<div class="main">
		<h2>Search for Actor:</h2>
		<form method="post" action="http://localhost:8888/search.php">
			<input type="text" name="item-actor" class="new-item"/>
			<input type="submit" name="submit-actor" />
		</form>
		<h2>Search for Movie:</h2>
		<form method="post" action="http://localhost:8888/search.php">
			<input type="text" name="item-movie" class="new-item"/>
			<input type="submit" name="submit-movie" />
		</form>
	</div>

<?php
//connect php to sql
$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) {
	die('Unable to connect to database [' . $db->connect_error . ']');
}

//if no parameter given in URL, page displays one or more search boxes to let user search for movie and actor
$param = $_POST['submit-actor'];
if (isset($param)) {
	$return = explode(" ", $_POST["item-actor"]);
	$search_length = count($return);
	if ((count($return)) == 1) {
		$param = "first LIKE '%".$return[0]."%' OR last LIKE '%".$return[0]."%';";
	} elseif ((count($return)) == 2) {
		$param = "first LIKE '%".$arr[0]."%' AND last LIKE '%".$return[1]."%';";
	} else {
		$param = "";
	}

	$query = "SELECT * FROM Actor WHERE ".$param;
	$rs = $db->query($query);
	if (!$rs) {
		$errormsg = $db->error;
		print 'Query failed: $errormsg <br>';
		exit(1);
	}
	if ($rs->num_rows > 0) {
		echo "<h2>Matching Actors are:</h2>
				<table>
					<thead>
						<tr>
							<td>Name</td>
							<td>Date of Birth</td>
						</tr>
					</thead>";
		while ($row = $rs->fetch_assoc()) {
			echo "<tbody>
					<tr>
						<td><a href='actor.php?id=".$row['id']."'>".$row['first']." ".$row['last']."</a></td>
						<td><a href='actor.php?id=".$row['id']."'>".$row['dob']."</a></td>
					</tr>";
		}
		echo "</tbody></table></div>";
	} else {
		echo "<br><h2>Matching Actors are:</h2>
				No Matching results";
	}
}

$param_2 = $_POST['submit-movie'];
if (isset($param_2)) {
	$return = explode(" ", $_POST["item-movie"]);
	$param_2 = "";
	foreach ($return as $val) {
		$param_2 .= "title LIKE '%".mysqli_real_escape_string($db, $val)."%' AND ";
	}
	$param_2 = substr($param_2, 0, -4);
	$query = "SELECT * FROM Movie WHERE ".$param_2.";";
	$rs = $db->query($query);
	if (!$rs) {
		$errormsg = $db->error;
		print 'Query failed: $errormsg <br>';
		exit(1);
	}
	if ($rs->num_rows > 0) {
		echo "<h2>Matching Movies are:</h2>
				<table>
					<thead>
						<tr>
							<td>Title</td>
							<td>Year</td>
						</tr>
					</thead>";
		while ($row = $rs->fetch_assoc()) {
			echo "<tbody>
					<tr>
						<td><a href='movie.php?id=".$row['id']."'>".$row['title']."</a></td>
						<td><a href='movie.php?id=".$row['id']."'>".$row['year']."</a></td>
					</tr>";
		}
		echo "</tbody></table></div>";
	} else {
		echo "<br><h2>Matching movies are:</h2>
				No Matching results";
	}
}

$db->close()
?>

</body>
</html>