<!DOCTYPE html>
<html>
<!--//page that shows actor information
//take actor id and display corresponding actor's information
//for every movie that the actor was in, the page must include a hyperlink to the corresponding movie page-->
<body>

<h1>Actor Information Page</h1>

<?php
//connect php to sql

$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) {
	die('Unable to connect to database [' . $db->connect_error . ']');
}

$param = $_GET["id"];
if (isset($param)) {
	$param_full = 'id='.$_GET['id'].";";
	$query = "SELECT * FROM Actor WHERE ".$param_full;
	$rs = $db->query($query);
	if (!$rs) {
		$errormsg = $db->error;
		print 'Query failed: $errormsg <br>';
		exit(1);
	}

	if ($rs->num_rows > 0) {
		echo "
		<h2>Actor Information is:</h2>
		<div class='table'>
			<table>
				<thead>
					<tr>
						<td>Name</td>
						<td>Sex</td>
						<td>Date of Birth</td>
						<td>Date of Death</td>
					</tr>
				</thead>";
		while ($row = $rs->fetch_assoc()) {
			echo "<tbody><tr>
					<td>".$row['first']." ".$row['last']."</td>
					<td>".$row['sex']."</td>
					<td>".$row['dob']."</td>
					<td>";
			if (isset($row['dod'])) {
				echo $row['dod'];
			} else {
				echo 'Still Alive';
			}
			echo "</td></tr></tbody>";
		}
		echo "</table></div>";
	} else {
		print "No results found<br>";
	}

	$param_info = 'MA.aid='.$param." AND MA.mid=M.id;";
	$query = "SELECT * FROM (Movie M, MovieActor MA) WHERE ".$param_info;
	$rs = $db->query($query);
	if (!$rs) {
		$errormsg = $db->error;
		print 'Query failed: $errormsg <br>';
		exit(1);
	}
	if ($rs->num_rows > 0) {
		echo "
		<h2>Actor's Movies and Role:</h2>
		<div class='table'>
			<table>
				<thead>
					<tr>
						<td>Role</td>
						<td>Movie Title</td>
					</tr>
				</thead>";
		while ($row = $rs->fetch_assoc()) {
			echo "<tbody>
					<tr>
						<td>".$row['role']."</td>
						<td><a href='movie.php?id=".$row['id']."'>".$row['title']."</a></td>
					</tr></tbody>";
		}
		echo "</table></div>";
	} else {
		print "No results found<br>";
	}
}

$db->close()
?>

</body>
</html>