<html>
 <head>
 <Title>Student Form</Title>
 <style type="text/css">
 	body { background-color: #fff; border-top: solid 10px #000;
      border-bottom: solid 10px #000;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	table { margin-top: 0.75em; }
 	th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
 	td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
 </style>
 </head>
 <body>
 <h1>Register Form</h1>
 <p>Fill in your name, address, gender, then click <strong>Submit</strong> to register.</p>
 <form method="post" action="index.php" enctype="multipart/form-data" >
       Name  <input type="text" name="name" id="name"/></br></br>
       Address <input type="text" name="address" id="address"/></br></br>
       Gender <select name="gender" id="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
       <input type="submit" name="submit" value="Submit" />
       <input type="submit" name="show_data" value="Load Data" />
 </form>
 <?php
    $host = "macdsubmission1.database.windows.net";
    $user = "firchan";
    $pass = "Sagasalare29";
    $db = "MACDsubmission1";
    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }
    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO Student (name, address, gender, date) 
                        VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $address);
            $stmt->bindValue(3, $gender);
            $stmt->bindValue(4, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
        echo "<h3>Registered Successfully!</h3>";
    } else if (isset($_POST['show_data'])) {
        try {
            $sql_select = "SELECT * FROM Student";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<h2>Student who are registered:</h2>";
                echo "<table>";
                echo "<tr><th>Name</th>";
                echo "<th>Address</th>";
                echo "<th>Gender</th>";
                echo "<th>Date</th></tr>";
                foreach($registrants as $registrant) {
                    echo "<tr><td>".$registrant['NAME']."</td>";
                    echo "<td>".$registrant['ADDRESS']."</td>";
                    echo "<td>".$registrant['GENDER']."</td>";
                    echo "<td>".$registrant['DATE']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No student is registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
 </body>
</html>
