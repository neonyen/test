<?
session_start();
include "db.php";

$query = "select * from gallery2 where id = '{$_REQUEST['id']}'";
$result = mysql_query($query);
$rowPhoto = mysql_fetch_array($result);


$query = "select * from content where name = 'gallery2'";
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
echo "<a name='a'></a><a name='top'></a><div style='float:left; padding-right:15px;'>";

######### Find next photo
$query = "select * from gallery2 where id > '{$rowPhoto['id']}' AND series2 = '{$rowPhoto['series2']}' limit 1";
$result = mysql_query($query);
if (mysql_numrows($result) < 1) {
$query = "select * from gallery2 where series2 = '{$rowPhoto['series2']}' order by id ASC limit 1";
$result = mysql_query($query);
}
$next = mysql_fetch_array($result);

  
  echo "<a href='?id={$next['id']}#a'><img src='gal/{$rowPhoto['photo']}' alt='View Next Product' title='View Next Product' border='0' /></a><br /><br />";
  
  $query3 = "select * from gallery2 where series2 = '{$rowPhoto['series2']}' order by id desc";
  $result3 = mysql_query($query3);
  while($rowPhoto3 = mysql_fetch_array($result3))
  {
    if ($rowPhoto['id'] == $rowPhoto3['id']) echo "<img src='gal/tn_{$rowPhoto3['photo']}' alt='{$rowPhoto3['name']}' title='{$rowPhoto3['name']}' border='1' height='40' style='opacity:0.3;filter:alpha(opacity=30)'/> ";
    else echo "<a href='?id={$rowPhoto3['id']}#a'><img src='gal/tn_{$rowPhoto3['photo']}' alt='{$rowPhoto3['name']}' title='{$rowPhoto3['name']}' border='1' height='40' /></a> ";
  
  }
  
  echo "</div> ";
   ##############
  ########## KEY
  ##############
  if ($_SESSION['unu2Sup32P4sS'] != '') echo "<a href='1dax.php?gallery2=1&id={$rowPhoto['id']}#a'><img src='key.png' alt='' border='0' /></a> ";
  ##############
  ##############
  ##############
  echo "<div class='nam'>{$rowPhoto['name']}</div>";
  echo "<div class='nam2'>&#36;{$rowPhoto['price']}</div>";
  
  $query = "select * from site where id ='1'";
$result = mysql_query($query);
$dax = mysql_fetch_array($result);


if ($rowPhoto['onoff'] == 'Out') echo "<font color='#FF0000'><b>Out of Stock</b></font><br />";
else
{
  ?>


<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    <input type="hidden" name="add" value="1">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="business" value="<? echo "{$dax['paypal']}"; ?>">
    <input type="hidden" name="item_name" value="<? echo "{$rowPhoto['name']}"; ?>">
    <input type="hidden" name="item_number" value="Database-ID <? echo "{$rowPhoto['id']}"; ?>">

    <input type="hidden" name="amount" value="<? echo "{$rowPhoto['price']}"; ?>">
    <input type="hidden" name="no_shipping" value="2">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="weight" value="0.5">
    <input type="hidden" name="weight_unit" value="lbs">
    <input type="hidden" name="lc" value="US">
    <input type="hidden" name="bn" value="PP-ShopCartBF">
    </form>


    <form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="business" value="<? echo "{$dax['paypal']}"; ?>">
    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_viewcart_SM.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
    <input type="hidden" name="display" value="1">
    </form>


    <?
 }   
  echo $rowPhoto['description'];
  

echo "<br /><a href='shop.php#{$rowPhoto['id']}'>";
echo "<i>Return</i></a></td></tr></table>";


include "templ/footer.php";
?>