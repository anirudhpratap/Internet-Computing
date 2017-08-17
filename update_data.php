<?php
require_once 'anilogin.php';

$conn = new mysqli($hn, $un, $pw, $db);
// define variables and set to empty values
$fnameErr = $lnameErr = $emailErr = $websiteErr = $phoneErr = $currencyErr = $locationErr = $pshareErr = $nshareErr = "";
$firstname = $lastname = $email = $website = $phone = $pricepershare = $numberofshare = "";
$check = 0;
$begin = 1;
$id="";
$currency = "";
$state = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$id = $_POST["id"];
	if ($id == '') {
    echo "Record can not be updated!!";
    } else {
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
  	  
  $currency = test_input($_POST["currency"]);
  
  $state = test_input($_POST["state"]);
  
if ($conn->connect_error) die($conn->connect_error);
       if ($check == 0) {
            $updatequery = "UPDATE form SET "
                    . "firstname = '" . $firstname . "', lastname= '" . $lastname . "', email= '" . $email . "', "
                    . "website = '" . $website . "', currency= '" . $currency . "', phone= '" . $phone . "', "
                    . "pricepershare= '" . $pricepershare . "', numberofshare= '" . $numberofshare . "',"
                    . "state= '" . $state . "' "
                    . "WHERE id= " . $id . ";";

            $result = $conn->query($updatequery);
            if (!$result) {
                echo "Update failed: $updatequery<br>" . $conn->error . "<br><br>";
            } else {
                echo "Data Updated Successfully!!<br>";
            }
            
        }
    }
    /*     * ************************ DBQuery - end ***************************************** */
} else {
    $id='';
    if (!empty($_GET) && $_GET['id']) {
        $selectQuery = "SELECT * FROM form WHERE id=" . $_GET['id'];
        $result_trades = $conn->query($selectQuery);
        $row = $result_trades->fetch_array(MYSQLI_ASSOC);

        if (empty($row)) {
            $error_notify = "Record Not Found!!";
        } else {
            foreach ($row as $key => $value) {
                $$key = $value;
				}
            
        }
    } else {
        $error_notify = "Record Not Found!!";
    }
}
?>
<html>
<head lang="en">
   <meta charset="utf-8">
   <title>Sign Up</title>   
   <script type="text/javascript" language="javascript" src="js_form.js"></script>
   <link rel="stylesheet" href="formcss.css" />
   </head>
<body>
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
<form method="post" name="Form" action="update_data.php?id=<?php echo $id; ?>">
<fieldset>
<legend>Stock Input Information</legend>
First Name:<input type="text" name="firstname" value='<?php echo $firstname; ?>' class="fn"><span class="error">* <?php echo $fnameErr;?></span><br><br>
Last Name:<input type="text" name="lastname" value='<?php echo $lastname; ?>'class="ln"><span class="error">* <?php echo $lnameErr;?></span><br><br>
Phone Number:<input type="text" name="phone" value='<?php echo $phone; ?>' placeholder="xxx-xxxx-xxxx" class="pn"><span class="error">* <?php echo $phoneErr;?></span><br><br>
Email:<input type="text" name="email" placeholder="xxxxxxx@xxxx.xxx" value='<?php echo $email; ?>' class="email"><span class="error">* <?php echo $emailErr;?></span><br><br>
Website:<input type="text" name="website" value='<?php echo $website; ?>'><span class="error">* <?php echo $websiteErr;?></span><br><br>
Price per Share: <input type="text" name="pricepershare" value='<?php echo $pricepershare; ?>' class="money"><span class="error">* <?php echo $pshareErr;?></span><br><br>
Number of Shares: <input type="text" name="numberofshare" value='<?php echo $numberofshare; ?>' class="qt"><span class="error">* <?php echo $nshareErr;?></span><br><br>
Please select one if you would like to recieve promotional offers?<br>
<input type="checkbox" id = "s" name="promotional" value="SMS" class="promo">SMS<br>
<input type="checkbox" id = "e" name="promotional" value="E-mail" class="promo">E-mail<br>

  <input type="hidden" name ="id" value="<?php echo $id; ?>" />
<input type="image" src="submit.png" alt="submit" title="Submit" width=80 height=20/>
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