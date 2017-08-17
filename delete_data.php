<?php
error_reporting(E_ALL);

ini_set('display_errors', 1);

//--------------------------------------DELETE RECORD - DATABASE-----------------------------------------------
//Obtain login credentials
require_once 'anilogin.php';

//Create connection to database
$conn = new mysqli($hn, $un, $pw, $db);

//Check if connection succeeded
if ($conn->connect_error) die($conn->connect_error);

//Verify if user already chose record to be deleted from the database table
if (isset($_POST['delete']) && isset($_POST['id'])) {

	//Delete record from table
	$id = get_post($conn, 'id');

    $query  = "DELETE FROM form WHERE id='$id'";

    $result = $conn->query($query);

    //If query fails, display error message
    if (!$result) {
    	echo "DELETE failed: $query <br />" . $conn->error . "<br /><br />";
    } else {
    	//If query succeeded, display success message
    	echo "Record deleted successfully!";
    }
}
//----------------------------------------RETRIEVE RECORDS - DATABASE--------------------------------------------------
//Retrieve records
$query  = "SELECT * FROM form";
$result = $conn->query($query);

//Check if query succeeded
if (!$result) die ("Database access failed: " . $conn->error);

//Display retrieved records
$rows = $result->num_rows;
for ($j = 0 ; $j < $rows ; ++$j) {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
  	<pre>
    	id $row[0]
      firstname $row[1]
      lastname $row[10]
	  email $row[2]
	  website $row[3]
	  currency $row[4]
	  pricepershare $row[5]
	  numberofshare $row[6]
	  promotional $row[7]
	  state $row[8]
	  phone $row[9]
  	</pre>
  	<form action="delete_data.php" method="post">
  	<input type="hidden" name="delete" value="yes">
  	<input type="hidden" name="id" value="$row[0]">
  	<input type="submit" value="DELETE RECORD"></form><br /><br />
_END;
}

$result->close();

//echo "<a href='home.html'>Home</a>";

//Close connection
$conn->close();

//Function to format string
function get_post($conn, $var) {
	return $conn->real_escape_string($_POST[$var]);
}

?>