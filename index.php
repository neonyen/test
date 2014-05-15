<?
include "templ/secure.php";
session_start();
include "db.php";

$superpage = "Homepage";

$query = "select * from content where name = '$superpage'";
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

###################################### START


##############
########## KEY
##############
if ($_SESSION['unu2Sup32P4sS'] != '') echo "<a href='1dax.php?text=1&page=$superpage#a'><img src='key.png' alt='' border='0' /></a> ";
##############
##############
##############

echo "<div>{$dax['text']}</div>";


###################################### END
 include "templ/footer.php"; 
 ?>