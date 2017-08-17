<html>
<head lang="en">
   <meta charset="utf-8">
   <title>Sign Up</title>   
   <script type="text/javascript" language="javascript" src="js_form.js"></script>
   <link rel="stylesheet" href="formcss.css" />
   </head>
<body>

<?php
error_reporting(E_ALL);

ini_set('display_errors', 1);

// define variables and set to empty values
$fnameErr = $lnameErr = $emailErr = $websiteErr = $phoneErr = $currencyErr = $locationErr = $pshareErr = $nshareErr = "";
 $firstname = $lastname = $email = $website = $phone = $pricepershare = $numberofshare = "";
 $check = 0;
 $begin = 0; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$begin = 1;	
  if (empty($_POST["firstname"])) {
    $fnameErr = "First Name is required";
	$check++;
  } else {	  
    $firstname = test_input($_POST["firstname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
      $fnameErr = "Only letters and white space allowed"; 
	  $check++;
	  $begin++;
    }
  }
  if (empty($_POST["lastname"])) {
    $lnameErr = "Last Name is required";
	$check = 0;
  } else {
	  
    $lastname = test_input($_POST["lastname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
      $lnameErr = "Only letters and white space allowed"; 
	  $check++;
    }
  }
  if (empty($_POST["pricepershare"])) {
    $pshareErr = "Price per share is required (decimals allowed)";
	$check++;
  } else {
	  
    $pricepershare = test_input($_POST["pricepershare"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!is_numeric($pricepershare)) {
      $pshareErr = "Enter a valid price of shares (decimals allowed)"; 
	  $check++;
    }
  }
  if (empty($_POST["numberofshare"])) {
    $nshareErr = "Number of shares is required";
	$check++;
  } else {
	  
    $numberofshare = test_input($_POST["numberofshare"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/^[0-9]*$/", $numberofshare)) {
      $nshareErr = "Enter a valid number of shares"; 
	  $check++;
    }
  } 
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
	$check++;
  } else {
	  
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format, please enter in xxxxx@xxxx.xxx format"; 
	  $check++;
    }
  }
  if (empty($_POST["phone"])) {
    $phoneErr = "Phone number is required";
	$check++;
  } else {
    $phone = test_input($_POST["phone"]);
	
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
      $phoneErr = "Invalid Phone number, please enter in XXXXXXXXXXX (10 DIGIT) format"; 
	  $check++;
    }
  }
  if (empty($_POST["website"])) {
    $websiteErr = "Enter your website";
	$check++;
  } else {
	  
    $website = test_input($_POST["website"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      $websiteErr = "Invalid URL"; 
	  $check++;
    }
  }
  
  
  ;
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

require_once 'anilogin.php';

//Create connection to database
$conn = new mysqli($hn, $un, $pw, $db);

//Check if connection succeeded
if ($conn->connect_error) die($conn->connect_error);

//Verify if user already entered data to be added to the database table
if ($check == 0 && $begin == 1)
{
	$firstname = get_post($conn, 'firstname');
    $lastname = get_post($conn, 'lastname');
	$email = get_post($conn, 'email');
	$phone = get_post($conn, 'phone');
	$website = get_post($conn, 'website');
	$currency = get_post($conn, 'currency');
	$pricepershare = get_post($conn, 'pricepershare');
	$numberofshare = get_post($conn, 'numberofshare');
	$state = get_post($conn, 'location');
	//Add record to table
	$query = "INSERT INTO form (firstname, lastname, email, website, currency, phone, pricepershare, numberofshare, state) VALUES " . 
	"('$firstname', '$lastname', '$email', '$website', '$currency', '$phone', '$pricepershare', '$numberofshare', '$state')";
    $result = $conn->query($query);

    //If query fails, display error message
    if (!$result){
    	echo "INSERT failed: $query <br />" . $conn->error . "<br /><br />";
    } else {
    	//If query succeeded, display success message
    	echo "Record added successfully!<br /><br />";
    }
} 
	

//Close connection
$conn->close();

//Function to format string
function get_post($conn, $var) {
	return $conn->real_escape_string($_POST[$var]);
}

?>

<header>
  <marquee><h1>Welcome to Stock Exchange System</h1></marquee>
<center>
<nav class="top">
	<a href="homepage.html">Home</a>
	<a href="form.html">Transactions</a>
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
</ul>
</nav>
</div>
<div class="mdl">
<p><span class="error">* required field.</span></p>
<form method="post" name="Form" action="add_validate.php">
<fieldset>
<legend>Stock Input Information</legend>
First Name:<input type="text" name="firstname" class="fn"><span class="error">* <?php echo $fnameErr;?></span><br><br>
Last Name:<input type="text" name="lastname" class="ln"><span class="error">* <?php echo $lnameErr;?></span><br><br>
Phone Number:<input type="text" name="phone" placeholder="xxx-xxxx-xxxx" class="pn"><span class="error">* <?php echo $phoneErr;?></span><br><br>
Email:<input type="text" name="email" placeholder="xxxxxxx@xxxx.xxx" class="email"><span class="error">* <?php echo $emailErr;?></span><br><br>
Website:<input type="text" name="website"><span class="error">* <?php echo $websiteErr;?></span><br><br>
Transaction Currency: <select name="currency" id="curr" class="currency" >
    <option value="">Select Currency</option>
    <option value="euro">European Euro - EUR</option>
    <option value="USD">United States Dollar - USD</option>
    <option value="AUD">Australian Dollar - AUD</option>
	<option value="yen">Japanese Yen - JPY</option>
	<option value="pound">United Kingdom Pound - GBP</option>
	<option value="rupee">Indian Ruppee - INR</option>
    </select></span><br><br>
Price per Share: (less than 100 only) <input type="text" name="pricepershare" class="money"><span class="error">* <?php echo $pshareErr;?></span><br><br>
Number of Shares: <input type="text" name="numberofshare" class="qt"><span class="error">* <?php echo $nshareErr;?></span><br><br>
Please select one if you would like to recieve promotional offers?<br>
<input type="checkbox" id = "s" name="promotional" value="SMS" class="promo">SMS<br>
<input type="checkbox" id = "e" name="promotional" value="E-mail" class="promo">E-mail<br>
Select your State: <select name="location" id = "state" value="location" class="state"><br>
    <option value="">Select location</option>
    <option value="dc">DC</option>
    <option value="va">VA</option>
    <option value="md">MD</option>
    <option value="ca">CA</option>
    <br>
  </select><br><br>
<input type="image" src="submit.png" alt="submit" title="Submit" width=80 height=20>
<input type="reset"><br><br>
</form>
</div>
<div class="rhs">
<nav>
<ul>
<li><a href=#>Products</a></li>
<li><a href=#">Technology</a></li>
<li><a href=#>Education</a></li>
<li><a href=#>Research</a></li>
</ul>
</nav>
</div>
<footer>
<nav class="ft">
<p><a href=#>Sitemap</a></p>
<p><a href=#>Disclaimer</a></p>
<p><a href=#>Terms of Use</a></p>
<p><a href="contactus.html">Contact Us</a></p>
</nav>
<p class="sharing">Share:
 <img src="mail.png" alt="Send Email" title="email" />
 <img src="fb.png" alt="Share this on Facebook" title="fb" />
 <img src="twitter.png" alt="Share this on Twitter" title="tweet" />
</p>
</p>
<p> Copyright &copy; 2017 - Anirudh Pratap. All Rights Reserved</p>
</footer>
</body>
</html>