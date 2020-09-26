<?php
// PHP - Validate Name
/*The code below shows a simple way to check if the name field only contains letters, dashes, 
apostrophes and whitespaces. If the value of the name field is not valid, then store an error message:*/
$name = test_input($_POST["name"]);
if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
  $nameErr = "Only letters and white space allowed";
}


/*he easiest and safest way to check whether an email address is well-formed is to use PHP's filter_var() function.
In the code below, if the e-mail address is not well-formed, then store an error message:*/
$email = test_input($_POST["email"]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $emailErr = "Invalid email format";
}



/*The code below shows a way to check if a URL address syntax is valid (this regular expression also allows dashes in the URL).
 If the URL address syntax is not valid, then store an error message:*/
$website = test_input($_POST["website"]);
if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
  $websiteErr = "Invalid URL";
}

// ₦ ₦ ₦₦ ₦₦₦ ₦₦₦ ₦₦₦₦ ₦


$str = "<h1>Hello World!</h1>";
$newstr = filter_var($str, FILTER_SANITIZE_STRING);
echo $newstr; //echos=> hello world


$email = "john.doe@example.com";
// Remove all illegal characters from email
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

// Validate e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
  echo("$email is a valid email address");
} else {
  echo("$email is not a valid email address");
}