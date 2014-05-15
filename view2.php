<?
include "templ/secure.php";
session_start();
include "db.php";


$query = "select * from videos where id = '{$_REQUEST['id']}'";
  $result = mysql_query($query);
  if (mysql_numrows($result) < 1)
{
    header("location:index.php");
    exit;
}
$daxvid = mysql_fetch_array($result);

  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $daxvid['name']; ?></title>
<meta name="keywords" content="<? echo $daxvid['name']; ?>" />
<? $text = $daxvid['description']; ?>
<meta name="description" content="<? echo strip_tags($text); ?>" />
<?

include "templ/header.php";

###################################### START

#show links

  

    $vid = $daxvid['url'];
    $parts = explode("&",$vid); 
    $url = $parts['0']; 

    ?>
    <a name='a'></a><div style='float:left; padding-right:20px;'><iframe width="640" height="480" src="http://www.youtube.com/embed/<? echo substr($url, 31); ?>?rel=0" frameborder="0" allowfullscreen></iframe></div>
    <?
##############
########## KEY
##############
if ($_SESSION['unu2Sup32P4sS'] != '') echo "<a href='1dax.php?videos=1&id={$daxvid['id']}#a'><img src='key.png' alt='' border='0' /></a> ";
##############
##############
##############
    echo "<div class='nam'>{$daxvid['name']}</div><br />";
    echo "<div>{$daxvid['description']}</div>";

echo "<div style='padding-top:11px;'><font size='1'>Other Videos</font></div>";
  $query3 = "select * from videos where id <> '{$daxvid['id']}' order by id desc";
$result3 = mysql_query($query3);
while ($row3 = mysql_fetch_array($result3))
{

  echo "<a href='view2.php?id={$row3['id']}#a'><img style='width:80px;' src='{$row3['photo']}' alt='{$row3['name']}' title='{$row3['name']}' /></a> ";

}

###################################### END
 include "templ/footer.php"; 
 ?>