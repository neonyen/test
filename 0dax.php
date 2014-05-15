<?
include "templ/secure.php";
session_start();
if ($_REQUEST['action'] == 'login')
{
  if ($_REQUEST['secureit'] != '987654321')
  {
    header("location:index.php");
    exit;
  }
  
}

include "db.php";

################################ Test Cookies
setcookie('nom-nom',hi,time() + (6000));
if ($_COOKIE['nom-nom'] == '')
{
    include "templ/header.php";
    echo "<div class='error'>Sorry!</div>For Security purposes you need Cookies Activated on this Computer to Proceed.";
    echo "<div class='nam'><a href='0dax.php'><b><i>Eat</b> the <b>Cookie!</b></i></a></div>";
    include "templ/footer.php";
    exit;
}

if ($_SESSION['T3st1n4'] == '')
{
  $_SESSION['T3st1n4'] = '1';
}
else
{
  $x = $_SESSION['T3st1n4'];
  if ($x > 4)
  {
    include "templ/header.php";
    echo "<div class='error'>You have Failed to Login</div>For Security purposes you may not attempt to do so again for 15 minutes.";
    include "templ/footer.php";
    exit;
   }
}

if ($_REQUEST['logout'] == '1')
{
	$_SESSION['unu2Sup32P4sS'] ='';
}
if ($_SESSION['unu2Sup32P4sS'] !='')
{ 
  header("location:1dax.php");
}

if ($_POST['action'] == 'login')
{
   $x = $_SESSION['T3st1n4'];
   $x = ($x + 1);
   $_SESSION['T3st1n4'] = $x;
   if ($x > 4)
   {
    include "templ/header.php";
    echo "<div clas='error'>You have Failed to Login</div>For Security purposes you may not attempt to do so again for 15 minutes.";
    include "templ/footer.php";
    exit;
   }
	
	$name = $_REQUEST['name'];
	$pass = $_REQUEST['pass'];
	$name = str_replace(" ", "", "$name");
	$pass = str_replace(" ", "", "$pass");	
	$name = htmlspecialchars(stripslashes(strip_tags($name))); //parse unnecessary characters to prevent exploits
	$pass = htmlspecialchars(stripslashes(strip_tags($pass))); //parse unnecessary characters to prevent exploits
	$query = "select id from user where email = '$name' and pass = '$pass'";
	$result = mysql_query($query);
	
	if (mysql_numrows($result) >0)
	{
		$_SESSION['unu2Sup32P4sS'] = mysql_result($result,0,0);
		$id = $_SESSION['unu2Sup32P4sS'];
  $date = date(U);
  $query = "insert into times (date, userid) values('$date', '$id')";
  mysql_query($query);
		header("location:1dax.php");
	}
	
	else echo "<div class='error'>Error! Email or Password was incorrect.</div>";
}

if ($_SESSION['unu2Sup32P4sS'] =='')
{


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Secure Login Area</title>
<?

include "templ/header.php";

  ?>
  <div class='nam2'>Employee Login - <a href='lostpw.php'>Lost Password?</a></div><br />
  
  <form action='0dax.php' method='post'>
  
  Security Code: <input type='text' name='secureit' class='int4'>
  Username: <input type='text' name='name' class='int4'>
  Password: <input type='password' name='pass' class='int4'>
  <input type='hidden' name='action' value='login'>
  <input type='submit' name='submit' value='Login'>
  </form>
  <?
  
  include("templ/footer.php");
  exit;
}
?>