
<?php

require_once 'anilogin.php';
echo "login params: hostname = " . $hn . "; username = " . $un . "; password = ******* " . "; db name = " .$db;
// Create connection
$conn = new mysqli($hn, $un, $pw);
// Check connection
 if ($conn->connect_error) {
     echo "<br/>";
     die("Die - Connection failed: " . $conn->connect_error);

}
// Create database
$sql = "CREATE DATABASE " . $db ;
echo "<br/>";
echo "Create db sql: " . $sql;
if ($conn->query($sql) === TRUE) {
     echo "<br/>";
     echo "Database created successfully";
}   else {
     echo "<br/>";
     //die("Die - Create DB failed: " . $conn->error);
}
// Close connection then reopen with $db
$conn->close();
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
   echo "<br/>";
   die("Connection with db failed: " . $conn->connect_error);
}  else {
     echo "<br/>";
     echo "Connection with db: $db succeeded";
}

$sql = "CREATE TABLE form (" .
 "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, " .
 "firstname VARCHAR(30) NOT NULL, " .
 "lastname VARCHAR(30) NOT NULL, " .
 "email VARCHAR(30) NOT NULL, " .
 "website VARCHAR(30) NOT NULL, " .
 "currency VARCHAR(30) NOT NULL, " .
 "phone INT NOT NULL, " .
 "pricepershare DECIMAL(6,4) NOT NULL, " .
 "numberofshare INT NOT NULL, " .
 "promotional VARCHAR(30), " .
 "state VARCHAR(20) NOT NULL)";

echo "<br/>";
echo "sql for create table: " . $sql;

if ($conn->query($sql) === TRUE) {
    echo "<br/>";
    echo "Table created successfully";

} else {
    echo "<br/>";
    echo "Error creating table: " . $conn->error;

}
echo "<br/>";
echo "Connected successfully";

 ?>
