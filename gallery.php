<?
session_start();
include "db.php";

$superpage = 'Gallery';

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

##############
########## KEY
##############
if ($_SESSION['unu2Sup32P4sS'] != '') echo "<a href='1dax.php?text=1&page=$superpage#a'><img src='key.png' alt='' border='0' /></a> ";
##############
##############
##############

echo "<div>{$dax['text']}</div>";

echo "<div class='nam2'>";

$query = "select * from series where name <> 'Website Images' order by name";
  $result = mysql_query($query);
  while ($row = mysql_fetch_array($result))
  {
    echo "&nbsp;<a href='gallery.php?area=" . urlencode($row['name']) . "'>{$row['name']}</a> | ";
  }

echo "</div>";

if ($_REQUEST['area']) echo "<br /><div class='nam2'>Now Viewing {$_REQUEST['area']}</div>";

if ($_POST['action']=='searchln')
{
echo "<div class='nam'>Search Results</div><br>\n";

	$searchname = $_POST['find'];
	
	if ($searchname == '') $searchname='%';
	
	$query = "select * from gallery where name like '%$searchname%'";
	$result = mysql_query($query);
	if (mysql_numrows($result) == 0) echo "No Search Listings were Found";
	while ($row = mysql_fetch_array($result))
	{
		echo "<a href='view.php?area={$row['series']}&id=" . $row['id'] . "#a'><img src='gal/tn_" . $row['photo'] . "' width='80'> <b>" . $row['name'] . "</b></a>";
		echo "<hr />\n";


	}
include "templ/footer.php";
exit;
}



echo "<center>";

$id = $_REQUEST['id'];
$name = $_REQUEST['name'];
$area = $_REQUEST['area'];

if ($area == '')
{
 $query = "select * from gallery where series <> 'Website Images' order by id desc";
 }
else if ($id != '') $query = "select * from gallery where id ='$id'";
else if ($area != '') $query = "select * from gallery where series ='$area' order by id desc";
$result = mysql_query($query);

echo "<br /><br />";

if (mysql_numrows($result) < 1) echo "<div class='nam2'><i>Sorry, No Search Results were found</i></div>";
while ($row = mysql_fetch_array($result))
{				
	echo "<div style='width:210px; border:1px solid #333333; height:200px; float:left; margin-right:16px; margin-left:16px; margin-bottom:10px;'>\n";
  echo "<div style='padding:5px; text-align:center;'>\n";
  
  echo "<a name='{$row['id']}'>&nbsp;</a>";
  ##############
  ########## KEY
  ##############
  if ($_SESSION['unu2Sup32P4sS'] != '') echo "<a href='1dax.php?gallery=1&id={$row['id']}#a'><img src='key.png' alt='' border='0' /></a> ";
  ##############
  ##############
  ##############

  echo "<div><a href='view.php?area=$area&id={$row['id']}#a'><img style='max-width:150px; max-height:122px;' src='gal/tn_{$row['photo']}' alt='{$row['name']}' title='{$row['name']}' /></a><br /><br /><font size='1'>{$row['name']}</font></div>";
  echo "</div></div>";
}



echo "<div class='clearme'>&nbsp;</div>";
include("templ/footer.php"); 

?>