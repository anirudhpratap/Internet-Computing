<?php
error_reporting(E_ALL);

ini_set('display_errors', 1);

//----------------------------------------RETRIEVE RECORDS - DATABASE--------------------------------------------------
//Obtain login credentials
require_once 'anilogin.php';

//Create connection to database
$conn = new mysqli($hn, $un, $pw, $db);

//Check if connection succeeded
if ($conn->connect_error) die($conn->connect_error);

//Retrieve records
$query  = "SELECT * FROM form";
$result = $conn->query($query);

//Check if query succeeded
if (!$result) die ("Database access failed: " . $conn->error);

//Display retrieved records
$rows = $result->num_rows;
?>
<html>
<head lang="en">
   <meta charset="utf-8">
   <title>Stock Exchange</title>   
   <link rel="stylesheet" href="table.css" />    
</head>
<body>
<header>
  <marquee><h1>Welcome to Stock Exchange System</h1></marquee>
<center>
<nav class="top">
	<a href="homepage.html">Home</a>
	<a href="form.html">Insert Transactions</a>
	<a href="table.html">Transaction Tables</a>
	<a href="Contactus.html">Contact Us</a>
</nav>
</center>
</header>
<div class="lhs">
<nav>
<ul>
  <li><a href=#>Live Market</a></li>
  <li><a href=#>Corporates</a></li>
  <li><a href=#>Domestic Investors</a></li>
  <li><a href=#>International Investors</a></li>
  <li><a href=#>Products</a></li>
  <li><a href=#">Technology</a></li>
  <li><a href=#>Education</a></li>
  <li><a href=#>Research</a></li>
</ul>
</nav>
</div>
<div class="mdl">
<table>
<caption>Record</caption>
 <tr>
    <th>ID</th>
	<th>First Name</th>
    <th>Last Name</th>
	<th>Email</th>
	<th>Website</th>
	<th>Currency</th>
	<th>Price per share</th>
	<th>Number of share</th>
	<th>promotional</th>
	<th>State</th>
	<th>Phone</th>	
	</tr>
<?php
for ($j = 0 ; $j < $rows ; ++$j) {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
      <td>$row[0]
      <td>$row[1]</td>
      <td>$row[10]</td>
	  <td>$row[2]</td>
	  <td>$row[3]</td>
	  <td>$row[4]</td>	  
	  <td>$row[5]</td>
	  <td>$row[6]</td>
	  <td>$row[7]</td>
	  <td>$row[8]</td>
	  <td>$row[9]</td>

	  
    </tr><br /><br />
_END;
}
?></table></body></html>
<?php
$result->close();
//Close connection
$conn->close();

?>