<?
include "templ/secure.php";
session_start();
include "db.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>F.A.Q</title>
<?

include "templ/header.php";

###################################### START

echo "<div style='padding-bottom:30px;'><form action='FAQ.php' method='post'>";
  echo "<input type='text' name='search' class='int3' size='60' />";
echo "<input type='submit' name='submit' value='Search F.A.Q.' />";
echo "</form></div>";

if ($_REQUEST['search'])
{
      $x = 0;
      $query = "select * from faq where question like'%{$_REQUEST['search']}%' OR answer like'%{$_REQUEST['search']}%'";
      $result = mysql_query($query);
      if (mysql_numrows($result) < 1) echo "<div class='nam1'>Sorry, no Search Results for <u>{$_REQUEST['search']}</u></div>";
      else 
      {
        $num = mysql_numrows($result);
        
        echo "<div><b>$num</b> Search Results for <u>{$_REQUEST['search']}</u></div>";
      }
      while ($row = mysql_fetch_array($result))
      {	
        $x = ($x + 1);
        echo "<div>";
        ##############
        ########## KEY
        ##############
        if ($_SESSION['unu2Sup32P4sS'] != '') echo "<a href='1dax.php?faq=1&id={$row['id']}#a'><img src='key.png' alt='' border='0' /></a> ";
        ##############
        ##############
        ##############
                
        echo "$x. <a href='?id={$row['id']}#{$row['id']}'><u>{$row['question']}</font></u></a></div>";
      }

  echo "<hr />";
}

################################################################### FAQ

      $query = "select id, question from faq order by question";
      $result = mysql_query($query);
      while ($row = mysql_fetch_array($result))
      {	
        echo "<div>";
        ##############
        ########## KEY
        ##############
        if ($_SESSION['unu2Sup32P4sS'] != '') echo "<a href='1dax.php?faq=1&id={$row['id']}#a'><img src='key.png' alt='' border='0' /></a> ";
        ##############
        ##############
        ##############
                
        echo "<a href='?id={$row['id']}#{$row['id']}'><u>{$row['question']}</font></u></a></div>";
      }
      echo "<br />";
      
      $query = "select * from faq order by question";
      $result = mysql_query($query);
      while ($row = mysql_fetch_array($result))
      {	
        echo "<a name='{$row['id']}'></a><hr />";
        
        ##############
        ########## KEY
        ##############
        if ($_SESSION['unu2Sup32P4sS'] != '') echo "<a href='1dax.php?faq=1&id={$row['id']}#a'><img src='key.png' alt='' border='0' /></a> ";
        ##############
        ##############
        ##############        
        echo "<div><font size='5'><i>Q:</font> {$row['question']}</i></div><br />";
        echo "<div><font size='5' face='impact'>A:</font> {$row['answer']}</div><br />";
      }
      

###################################### END
 include "templ/footer.php"; 
 ?>