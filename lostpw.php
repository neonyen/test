<?
include "db.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Help Area</title>
<?include "templ/header.php";

#----------------------Start---Password--


if ($_POST['action'] == 'helpme')
{

	$email = $_POST['email'];
	$user = $_POST['user'];
		$user = htmlspecialchars(stripslashes(strip_tags($user))); //parse unnecessary characters to prevent exploits
	$email = htmlspecialchars(stripslashes(strip_tags($email))); //parse unnecessary characters to prevent exploits
	if ($user != '')
	{
	echo "Thank you!";
	exit;
	}
	
	$query = "select email, pass from user where email = '$email'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if ($row['email'] != '')
	{
		$mailto = $row['email'];
		$subject = "Your Password";
		$name = "Help-Bot";
		$comments = $row['pass'];
		$emailx = "No-Reply@unu2.com";
		$email = strtok( $email, "\r\n" );
		
		$messageproper =
		
			"Your Password \n\n $comments";
		
		mail($mailto, $subject, $messageproper, "From: \"$name\" <$emailx>\r\nReply-To: \"$name\" <$emailx>\r\nX-Mailer: chfeedback.php 2.04" );
	
		echo "<div class='nam'>We found it!</div>";
		echo "Your Password has been Emailed to you!";
		include "templ/footer.php";
		exit;	
	}
	
	if ($row['email'] == '')
	{
	echo "<div class='nam'>Error</div>";
	echo "There isn't an Email Address on file that matches your request.<br> Hit your back button to try again.";
	include "templ/footer.php";
	exit;
	}
}

?>
<div class='nam'>Lost your Password?</div><br><br><center>
<form action='lostpw.php' method='post'>

<b>Enter your Email Address</b>: <input type='text' name='email' class='int4' />
<input type='hidden' name='user'>
<input type='hidden' name='action' value='helpme'>
<input type='submit' name='submit' value='Get Password'>
</div>

</form>




<?php include("templ/footer.php"); ?>
