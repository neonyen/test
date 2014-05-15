<?
include "templ/secure.php";
session_start();
include "db.php";

$query = "select * from gallery where id = '{$_REQUEST['id']}'";
$result = mysql_query($query);
$rowPhoto = mysql_fetch_array($result);


$query = "select * from content where name = 'Gallery'";
$result = mysql_query($query);
$dax = mysql_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo "{$rowPhoto['name']} at {$dax['title']}"; ?></title>
<meta name="keywords" content="<? echo "{$rowPhoto['name']}, {$dax['keywords']}"; ?>" />
<? $text = $rowPhoto['description']; ?>
<meta name="description" content="<? echo strip_tags($text); ?>" />
<?

include "templ/header.php";
echo "<center><a name='a'></a><table width='640'><tr><td><a name='top'></a>";

######### Find next photo
$query = "select * from gallery where id > '{$rowPhoto['id']}' AND series = '{$rowPhoto['series']}' limit 1";
$result = mysql_query($query);
if (mysql_numrows($result) < 1) {
$query = "select * from gallery where series = '{$rowPhoto['series']}' order by id ASC limit 1";
$result = mysql_query($query);
}
$next = mysql_fetch_array($result);

  
  echo "<a href='?id={$next['id']}#a'><img src='gal/{$rowPhoto['photo']}' alt='View Next Photo' title='View Next Photo' border='0' /></a><br /><br />";
  
  $query3 = "select * from gallery where series = '{$rowPhoto['series']}' order by id desc";
  $result3 = mysql_query($query3);
  while($rowPhoto3 = mysql_fetch_array($result3))
  {
    if ($rowPhoto['id'] == $rowPhoto3['id']) echo "<img src='gal/tn_{$rowPhoto3['photo']}' alt='{$rowPhoto3['name']}' title='{$rowPhoto3['name']}' border='1' height='40' style='opacity:0.3;filter:alpha(opacity=30)'/> ";
    else echo "<a href='?id={$rowPhoto3['id']}#a'><img src='gal/tn_{$rowPhoto3['photo']}' alt='{$rowPhoto3['name']}' title='{$rowPhoto3['name']}' border='1' height='40' /></a> ";
  
  }
  
  echo "</center> ";
   ##############
  ########## KEY
  ##############
  if ($_SESSION['unu2Sup32P4sS'] != '') echo "<a href='1dax.php?gallery=1&id={$row['id']}#a'><img src='key.png' alt='' border='0' /></a> ";
  ##############
  ##############
  ##############
  echo "<div class='nam'>{$rowPhoto['name']}</div>";
  echo $rowPhoto['description'];
  

echo "<br /><a href='gallery.php#{$rowPhoto['id']}'>";
echo "<i>Return</i></a></td></tr></table>";


include "templ/footer.php";
?>