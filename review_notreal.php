<!DOCTYPE html>
<html>
<body>
    <section id="search" class="search section-bg">
      <div class="container">

        <div class="section-title">
          <h2>REVIEW</h2>
          <p>Add A Review</p>
        </div>
        <?php 
        $servername = "localhost";
        $username = "cs143";
        $password = "";
        $dbname = "class_db";

        // Create connection
        $db = new mysqli($servername, $username, $password, $dbname);
        if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
        }

        if (isset($_GET["id"])) {
          // Get Movie Information
          $condition = 'id='.$_GET['id'].";";
          $query = "SELECT * FROM Movie WHERE ".$condition;
          echo "<br>";
          $rs = $db->query($query);
          if (!$rs) {
              $errmsg = $db->error; 
              print "Query failed: $errmsg <br>"; 
              exit(1); 
          }
          if ($rs->num_rows > 0) {
            echo "
            <br>
            <h5>Movie Title:</h5>";

            while ($row = $rs->fetch_assoc()) {  
              echo "<h3>".$row['title']." (".$row['year'].")</h3><br>";
              break;
            }

          } else {
            echo "
            <h5>0 results</h5>";
          }
        }
    ?>
    <form method="post">
          <div class="form-group"> 
              <label>Your Name:</label>
              <input type="text" class="form-control" placeholder="Your Name" name="name" value="Anonymous">
          </div>
          <br>
          <div class="form-group"> 
              <label>Rating:</label>
              <select class="form-control" name="rating" id="rating">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              </select>
          </div>
          <br>
          <div class="form-group"> 
              <label>Comment:</label>
              <textarea type="text" class="form-control" placeholder="Please input under 500 characters" name="comment" rows="10"></textarea>
          </div>
          <br><br>
          <button class="btn btn-primary">Rate it!</button>
        </form>
    <?php
        date_default_timezone_set('America/Los_Angeles');
        if (isset($_POST["comment"])) {
          // Get Movie Information
          $condition = "('".$_POST["name"]."', '".date('Y-m-d H:i:s')."', ".$_GET["id"].", ".$_POST["rating"].", '".$_POST["comment"]."');";
          $query = "INSERT INTO Review VALUES ".$condition;
          echo "<br>";
          $rs = $db->query($query);
          if (!$rs) {
              $errmsg = $db->error; 
              print "Query failed: $errmsg <br>"; 
              exit(1); 
          }
        }

      $db->close();
      ?>

    </section>
</body>
</html>