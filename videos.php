<?
session_start();
include "db.php";

$superpage = "Videos";

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

$query3 = "select * from videos order by id desc";
$result3 = mysql_query($query3);
while ($row3 = mysql_fetch_array($result3))
{
  echo "<div style='width:210px; border:1px solid #333333; height:150px; float:left; margin-right:16px; margin-left:16px; margin-bottom:5px;'>\n";
  echo "<div style='padding:5px; text-align:center;'>\n";
  echo "<a href='view2.php?id={$row3['id']}#a'><img style='max-width:160px; max-height:140px;' src='{$row3['photo']}' alt='{$row3['name']}' title='{$row3['name']}' /><br />{$row3['name']}</a> ";
  echo "</div></div>";
}


###################################### END
 include "templ/footer.php"; 
 ?>