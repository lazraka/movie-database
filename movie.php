<!DOCTYPE html>
<html>
<!-- page that shows movie information based on movie id, show hyperlinks to actor pages for each actor in movie,
show average score of movie based on user feedback, show all user comments, contain 'add comment' link/button that links to movie's review page -->
<body>

<h1>Movie Information Page</h1>

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
			<h2>Movie Information is: </h2>";
			while ($row = $rs->fetch_assoc()) {
				echo "Title: ".$row['title']." (".$row['year'].")"."<br>
						Producer: ".$row['company']."<br>
						MPAA Rating: ".$row['rating']."<br>
						Company: ".$row['company']."<br>";
			}
	} else {
		print "No results found<br>";
	}

	//Movie Genre
	$param_genre= 'M.id='.$param." AND M.id=MG.mid;";
	$query = "SELECT genre FROM (Movie M, MovieGenre MG) WHERE ".$param_genre;
	$rs = $db->query($query);
	if (!$rs) {
		$errormsg = $db->error;
		print 'Query failed: $errormsg <br>';
		exit(1);
	}
	if ($rs->num_rows > 0) {
		echo "Genre: ";
		while ($row = $rs->fetch_assoc()) {
			echo $row['genre']." ";
		}
	} else {
		echo "Genre: Not available";
	}

	//Actors in movie
	$param_actors= 'M.id='.$param." AND M.id=MA.mid AND A.id=MA.aid;";
	$query = "SELECT * FROM (Movie M, MovieActor MA, Actor A) WHERE ".$param_actors;
	$rs = $db->query($query);
	if (!$rs) {
		$errormsg = $db->error;
		print 'Query failed: $errormsg <br>';
		exit(1);
	}
	if ($rs->num_rows > 0) {
		echo "
			<h2>Actors in this Movie:</h2>
			<div class='table'>
			<table>
				<thead>
					<tr>
						<td>Name</td>
						<td>Role</td>
					</tr>
				</thead>";
		while ($row = $rs->fetch_assoc()) {
			echo "<tbody>
					<tr>
						<td><a href='actor.php?id=".$row['aid']."'>".$row['first']." ".$row['last']."</a></td>
						<td>".$row['role']."</td>
					</tr></tbody>";
		}
		echo "</table></div>";
	} else {
		print "No results found<br>";
	}

	//User Review
	$param_review= 'mid='.$param.";";
	$query = "SELECT AVG(rating), COUNT(comment) FROM Review WHERE ".$param_review;
	$rs = $db->query($query);
	if (!$rs) {
		$errormsg = $db->error;
		print 'Query failed: $errormsg <br>';
		exit(1);
	}
	if ($rs->num_rows > 0) {
		echo "
			<br><h3>User Review: </h3>";
			while ($row = $rs->fetch_assoc()) {
				echo "Average rating score for this movie is ";
				if (isset($row['AVG(rating)'])) {
					echo $row['AVG(rating)'];
				}
				echo "/5 based on ".$row["COUNT(comment)"]." people's reviews<br>";
				echo "<a href='review.php?id=".$param."'>Leave your review!</a><br>";
			}
	} else {
		print "No reviews found<br>";
	}
	
	//Comments
	$param_comments = 'mid='.$param.";";
	$query = "SELECT * FROM Review WHERE ".$param_comments;
	$rs = $db->query($query);
	if (!$rs) {
		$errormsg = $db->error;
		print 'Query failed: $errormsg <br>';
		exit(1);
	}
	if ($rs->num_rows > 0) {
			while ($row = $rs->fetch_assoc()) {
				echo $row['name']." rates the movie with a score of ".$row['rating']." and left a review at ".$row['time']."<br>";
				echo "Comment: <br>";
				if (isset($row['comment'])) {
					echo $row['comment'];
				} else {
					echo "";
				}
				echo "<br>";
			}
	} else {
		print "Comment: None added<br>";
	}
}

$db->close()
?>

</body>
</html>