<!DOCTYPE html>
<html>
<body>
      <!-- ======= Search Section ======= -->
    <section id="search" class="search section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Search</h2>
          <p>Search our Database</p>
        </div>
        
        <form method="post">
          <div class="input-group mb-3"> 
              <input type="text" class="form-control" placeholder="I'm looking for..." name="search">
              <button class="btn btn-primary">GO</button>
          </div>
        </form>
        <?php 
        $servername = "localhost";
        $username = "cs143";
        $password = "";
        $dbname = "cs143";

        // Create connection
        $db = new mysqli($servername, $username, $password, $dbname);
        if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
        }

        if (isset($_POST["search"])) {
          // Search Actors
          $condition = '';
          $arr = explode(" ", $_POST["search"]);
          $count = count($arr);
          if ($count == 1) {
            $condition = "first LIKE '%".$arr[0]."%' OR last LIKE '%".$arr[0]."%';";
          } 
          elseif ($count == 2) {
            $condition = "first LIKE '%".$arr[0]."%' AND last LIKE '%".$arr[1]."%';";
          } 
          
          $query = "SELECT * FROM Actor WHERE ".$condition;
          $rs = $db->query($query);
          if (!$rs) {
              $errmsg = $db->error; 
              print "Query failed: $errmsg <br>"; 
              exit(1); 
          }
          if ($rs->num_rows > 0) {
            echo "
            <br>
            <h3>Matching actors:</h3>
            <table>
              <tr>
                <th>Name</th>
                <th>Sex</th>
                <th>Date Of Birth</th>
                <th>Date Of Death</th>
              </tr>";
            while ($row = $rs->fetch_assoc()) {  
              echo "<tr><td>"."<a href='Actor.php?id=".$row['id']."'>".$row['first']." ".$row['last']."</a></td><td>".$row['sex']."</td><td>"."<a href='Actor.php?id=".$row['id']."'>".$row['dob']."</a></td><td>";
              echo isset($row['dod']) ? $row['dod'] : 'Still Alive';
              echo "</td><tr>";
            }
            echo "</table>";
          } else {
            echo "
            <br>
            <h3>Matching actors:</h3>
            <h5>0 results</h5>";
          }

          // search Movie
          $condition = '';
          foreach ($arr as $val) {
            $condition .= "title LIKE '%".mysqli_real_escape_string($db, $val)."%' AND ";
          }
          $condition = substr($condition, 0, -4); // remove the trailing AND
          $query = "SELECT * FROM Movie WHERE ".$condition.";";
          $rs = $db->query($query);
          if (!$rs) {
              $errmsg = $db->error; 
              print "Query failed: $errmsg <br>"; 
              exit(1); 
          }
          if ($rs->num_rows > 0) {
            echo "
            <br>
            <h3>Matching movies:</h3>
            <table>
              <tr>
                <th>Title</th>
                <th>Year</th>
                <th>Rating</th>
                <th>Company</th>
              </tr>";
            while ($row = $rs->fetch_assoc()) {  
              echo "<tr><td>"."<a href='Movie.php?id=".$row['id']."'>".$row['title']."</a></td><td>".$row['year']."</td><td>";
              echo isset($row['rating']) ? $row['rating'] : 'N/A';
              echo "</td><td>".$row['company']."</td><tr>";
            }
            echo "</table>";
          } else {
            echo "<br>
            <h3>Matching movies:</h3>
            <h5>0 results</h5>";
          }
        }
      $db->close();
      ?>
    </section>
</body>
</html>