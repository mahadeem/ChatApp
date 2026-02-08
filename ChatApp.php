<!DOCTYPE HTML>
<html>
<head>
</head>
<body>

<?php
echo "<br>";
require 'connect.inc.php'; //if using mysql this line required
error_reporting(E_ALL);
//require 'chatSession.php'; // build a session for better protection and security
//require 'function.php';// xss cross site protection file 
//require 'token.php';//csrf token for better protection and security
 $email = $_SESSION['email'];
 $sql = "SELECT firstname FROM users WHERE email = '".$_SESSION['email']."'"; 
 $stmt = $db->query($sql);
 if($stmt->num_rows > 0){
	while($row = $stmt ->fetch_assoc()){
 $comment = $_POST['comment'];
 $firstname = $row['firstname'];
 $ip_address = $_SERVER['REMOTE_ADDR'];
$sql = $db->prepare ("INSERT INTO comment (comment, firstname, email, ip_address) VALUES ( ?,?,?,?)");
$sql -> bind_param("ssss", $comment, $firstname,$email, $ip_address);
	 if($sql->execute()){
 
	} else {
		echo "sorry server is busy, please try again later";
	} 
}
	}
$db->close();
?>
<form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >  
   Comment: <textarea name="comment" rows="5" cols="40"></textarea>
   <br>

   <input type="submit" name="submit" value ="Submit">
   <input type = "hidden" name = "token" value = "<?php echo $token;?>" >
</form>

<?php

require 'connect.inc.php';
$sql = "SELECT * FROM comment";
$stmt = $db->query($sql);
echo "<h2> comments: </h2>";
if($stmt->num_rows > 0){
	while($row = $stmt ->fetch_assoc()){
		echo "<br>";
		echo $row["firstname"];
		echo ":";
		
		echo "<br>";
		echo $row["comment"];
echo "<br>";
	}
}
?>

<?php
date_default_timezone_set("America/Indiana/Knox");
echo "The time is " . date("h:i:sa");
echo "<br>";
?>



</body>
</html>
