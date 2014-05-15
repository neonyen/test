<?
session_start();
include "db.php";


if ($_POST['action'] == 'sendit')
{

$query = "select * from site where id ='1'";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

$mailto = $row['email'];
$subject = "Website Mail";
$name = fix($_REQUEST['name']);
$email = fix($_REQUEST['email']);
$comments = fix($_REQUEST['comments']);
$ip = $_REQUEST['ip'];
$besttime = fix($_REQUEST['besttime']);
$besttime = strtolower($besttime);


	$name = htmlspecialchars(stripslashes(strip_tags($name))); //parse unnecessary characters to prevent exploits
	$comments = htmlspecialchars(stripslashes(strip_tags($comments))); //parse unnecessary characters to prevent exploits
	
############################################### CHECK EMAIL
    $email = htmlspecialchars(stripslashes(strip_tags($email))); //parse unnecessary characters to prevent exploits
    
    if ( eregi ( '[a-z||0-9]@[a-z||0-9].[a-z]', $email ) ) 
    { //checks to make sure the email address is in a valid format
    $domain = explode( "@", $email ); //get the domain name
        
        if ( @fsockopen ($domain[1],80,$errno,$errstr,3)) 
        {
          $on = 'Fuckyeah';            
        } 
        else 
        {
            header("location:contact.php?error=email&name=$name&email=$email&com=$comments#e");
            exit;
        }
    
    } 
    else 
    {
        header("location:contact.php?error=email&name=$name&email=$email&com=$comments#e");
        exit;
    }
############################################### END CHECK

if ($email == '')
{
	 header("location:contact.php?error=email&name=$name&email=$email&com=$comments#e");
	 exit;
}

else if ($name == '')
{
	 header("location:contact.php?error=name&name=$name&email=$email&com=$comments#e");
	 exit;
}
else if ($besttime != 'lion')
	{
		echo "<div style='float:right;'>Thank you, however you didn't get the spam question correct.</div><div class='clearme'>&nbsp;</div>";
		include "templ/footer.php";
	 exit;
	}
else
  {

    $messageproper =

    "Contact Name: " .
      "$name\n" .
    "Email: " .
      "$email\n\n" .
      
      "Their IP Address: " .
      "$ip\n\n" .

    "Comments: " .
      "$comments\n";



    mail($mailto, $subject, $messageproper, "From: \"$name\" <$email>\r\nReply-To: \"$name\" <$email>\r\nX-Mailer: chfeedback.php 2.04" );

      header("location:contact.php?comp=1#e");
    include "templ/footer.php";
    exit;
  }
}

$superpage = 'Contact';
$query = "select * from content where name = 'Contact'";
$result = mysql_query($query);
$dax = mysql_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $dax['title']; ?></title>
<meta name="keywords" content="<? echo $dax['keywords']; ?>" />
<? $text = $dax['description']; ?>
<meta name="description" content="<? echo strip_tags($text); ?>" />
<?

include "templ/header.php";


echo "<a name='e'></a>";

if ($_REQUEST['error'] == 'name') echo "<div class='error'>Error! A Valid <b>Name</b> is Required</div>";
if ($_REQUEST['error'] == 'email') echo "<div class='error'>Error! A Valid <b>Email</b> is Required</div>";
if ($_REQUEST['tap'] == 'dance') echo "<div class='error'>Error! Please Check the <b>SPAM</b> question</div>";
if ($_REQUEST['comp']) 
{ 
  echo "<div class='nam'>Thank You!</div>";
  echo "<div class='nam2'>Your Letter Has Been Sent!</div>"; 
  include "templ/footer.php"; 
  exit; 
}
?>
<table><tr><td valign='top'>
<div class='nam'>Contact us</div>
<font size='1'>Fill in the Fields below.</font><br><br>
<form action='contact.php' method='post'>

<div><b><font color='#FF0000'>*</font> Your Name</b>: <input type='text' name='name' class='int4'></div><br />
<div><b><font color='#FF0000'>*</font> Your Email</b>: <input type='text' name='email' class='int4'></div><br />



<div><textarea rows="8" cols="42" name='comments' class='int5'></textarea></div>

<input type='hidden' name='ip' value='<? echo $_SERVER['REMOTE_ADDR']; ?>'>
<input type='hidden' name='action' value='sendit'>


<table width='300' height='50' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td valign='top' align='center' background='zebra/zebra1.png'>
			<img src='zebra/antelope1.png' width='250' height='50' alt='' border='0' /></td><td><input type='text' name='besttime' style='width:50px; background-color:#CC9999;' /></td>
	</tr>
</table>

<br />

<input type='submit' name='submit' value='Submit'>


</form>
</td><td width='100'></td><td valign='top' align='left' width='450'>

<?

##############
########## KEY
##############
if ($_SESSION['unu2Sup32P4sS'] != '') echo "<a href='1dax.php?text=1&page=$superpage#a'><img src='key.png' alt='' border='0' /></a> ";
##############
##############
##############

echo "<div>{$dax['text']}</div>";

?>

</td></tr></table>
<?

include "templ/footer.php"; ?>