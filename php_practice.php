<!DOCTYPE html>
<html>
<head>
	<title>Search Page</title>
	<meta name="description" content="Search Page for database"/>
</head>
<body>
	<div id="app">
		<header>
			<h1>Searching Page:</h1>
		</header>
		<div class="main">
			<h2>Search for Actor:</h2>
			<form method="post" action="http://localhost:8888/php_practice.php" class="new-item-form">
				<input type="text" name="item" class="new-item" value="Search..." />
				<input type="submit" name="submit" value="Search" class="add" />
			</form>
			<h2>Search for Movie:</h2>
			<form class="new-item-form">
				<input type="text" name="item" class="new-item" />
				<input type="submit" name="submit" value="Search" class="add" />
			</form>
			<ul class="todos"></ul>
		</div>
	</div>

<?php
echo "Hello World!";
?>

</body>
</html>