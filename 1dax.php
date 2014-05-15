<?
include "templ/secure.php";
session_start();
include "db.php";
if ($_SESSION['unu2Sup32P4sS'] =='')
{
  header("location:0dax.php");
}

# All Material Herein is held under strict Copyright (c) 2011 unu2 multimedia and Michael E. Clay
# This code is RENTED from unu2 multimedia and may not be taken, coppied or sharred from our Servers.
# Doing so violates our Terms of Services.
# Duplication will result in legal actions.
# Tracking and indentification code is present.



############################################################################### PRODUCT POST


if ($_REQUEST['action'] == 'gallery2')
{
	

	$name = fix($_REQUEST['name']);
  $series2 = fix($_REQUEST['series2']);
  $description = fix($_REQUEST['description']);
  $price = fix($_REQUEST['price']);
  $sku = fix($_REQUEST['sku']);
  $weight = fix($_REQUEST['weight']);
  $onoff = fix($_REQUEST['onoff']);
  $id = $_REQUEST['id'];
	
	if ($name == '')
	{
		header("location:1dax.php?gallery2=1&error=1#a");
		exit;
	}
	if ($price == '' || $weight == '')
	{
		header("location:1dax.php?gallery2=1&error=2#a");
		exit;
	}

	
	
		if (is_uploaded_file($_FILES['photo']['tmp_name']))
		{
			$ext = getFileExtension($_FILES['photo']['name'],$withperiod = false);
			$fname = date('U') . rand(0,99999) . "." . $ext;
			$ext = strtolower($ext);
			# Do some fucking security checking
			if ($ext == 'jpg' || $ext == 'JPG' || $ext == 'png' || $ext == 'PNG' || $ext == 'gif' || $ext == 'GIF')
			{
        $tay = 'Classy';
			}
			else
			{
        include "templ/header.php";
          echo "<div class='error'>Error! Uploaded File is Not Supported!</div>";
        include "templ/footer.php";
        exit;
			}
			
			$target_path = $base  . "gal/" . $fname;
			$thumb_path = $base  . "gal/tn_" . $fname;
						
			move_uploaded_file($_FILES['photo']['tmp_name'], $target_path);
			
			$imagedata = getimagesize($target_path);
			$width = $imagedata[0];
			$height = $imagedata[1];
		
			$w2 = 640;
			$h2 = round(($w2 * $height) / $width);
			
			resize2($target_path,$target_path,$width,$height,$w2,$h2);
			/*$im2 = ImageCreateTrueColor($w2, $h2);
			$image = ImageCreateFromJpeg($target_path);	
			imagecopyResampled ($im2, $image, 0, 0, 0, 0, $w2, $h2, $width, $height);		
			imageJPEG($im2,$target_path,100);*/
			
			$tw2 = 160;
			$th2 = round($h2 / 4);
			
			resize2($target_path,$thumb_path,$w2,$h2,$tw2,$th2);
			/*$im2 = ImageCreateTrueColor($tw2, $th2);
			$image = ImageCreateFromJpeg($target_path);	
			imagecopyResampled ($im2, $image, 0, 0, 0, 0, $tw2, $th2, $w2, $h2);		
			imageJPEG($im2,$thumb_path,100);*/
			
			if ($_REQUEST['water'] != '')
			{
        $watermark = imagecreatefrompng('watermark.png');
        $watermark_width = imagesx($watermark);
        $watermark_height = imagesy($watermark);
        $image = imagecreatetruecolor($watermark_width, $watermark_height);
        if ($ext == 'png') $image = imagecreatefrompng($target_path);
        else if ($ext == 'gif') $image = imagecreatefromgif($target_path);
        else if ($ext == 'jpg') $image = imagecreatefromjpeg($target_path);
        else  $image = imagecreatefromjpeg($target_path);
        $size = getimagesize($target_path);
        $dest_x = $size[0] - $watermark_width - 5;
        $dest_y = $size[1] - $watermark_height - 5;
        imagecopy($image, $watermark, $dest_x , $dest_y, 0, 0, $watermark_width, $watermark_height);
        imagejpeg($image, $target_path,100);
			}

			$upped = true;
		}
		else $fname = "none.jpg";
					
			
	if ($_REQUEST['delete'] == '1') 
	{
		$query = "select photo from gallery2 where id = '" . $_REQUEST['id'] . "'";
		$result = mysql_query($query);
		$photoname = mysql_result($result,0,0);
		if ($photoname != 'none.jpg')
			{
		unlink($base . "gal/" . $photoname);
		unlink($base . "gal/tn_" . $photoname);
		}
		$query = "delete from gallery2 where id = '" .$_REQUEST['id'] . "' limit 1";
			mysql_query($query);
	echo mysql_error();
	if ($_REQUEST[''] == '') $id = mysql_insert_id();
	else $id = $_REQUEST['id'];
	header("location:1dax.php");	
	
	}
	else if ($_REQUEST['id'] != '') 
	{
		if ($upped) 
		{
			$query = "select photo from gallery2 where id = '" . $_REQUEST['id'] . "'";
			$result = mysql_query($query);
			$photoname = mysql_result($result,0,0);
			
			if ($photoname != 'none.jpg')
			{
				unlink($base . "gal/" . $photoname);
				unlink($base . "gal/tn_" . $photoname);
			}
			$query = "update gallery2 set sku = '$sku', onoff = '$onoff', price = '$price', weight = '$weight', description = '$description', photo = '$fname', name = '$name', series2 = '$series2' where id ='" . $_REQUEST['id'] . "' limit 1";
		
		}
		else $query = "update gallery2 set sku = '$sku', onoff = '$onoff', price = '$price', weight = '$weight', description = '$description', name = '$name', series2 = '$series2' where id ='" . $_REQUEST['id'] . "' limit 1";

	}
	else 
	{
		
		
		$query = "insert into gallery2(sku, price, weight, name, photo, series2, description, onoff) values('$sku', '$price', '$weight', '$name', '$fname', '$series2', '$description', '$onoff')";	
		
	}
	mysql_query($query);
	echo mysql_error();
	if ($_REQUEST['id'] == '') $id = mysql_insert_id();
	else $id = $_REQUEST['id'];

	

	
	

	header("location:1dax.php?gallery2=1&comp=1#a");

}	





############################################################################### series2

if ($_REQUEST['action'] == 'series2')
{

$name = fix($_REQUEST['name']);
$id = $_REQUEST['id'];
$delete = $_REQUEST['delete'];

if ($name == '')
{
  header("location:1dax.php?series2=1&error=1#a");
  exit;
}



	if ($delete == '1')
	{
		$query = "delete from series2 where id = '$id' limit 1";		
	}

	else if ($id != '')
	{
		
		$query = "select name, id from series2 where id = '$id'";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		
		$query = "select * from gallery2 where series2 = '{$row['name']}'";
		$result = mysql_query($query);
		

		
		while($row2 = mysql_fetch_array($result))
		{
      $query2 = "update gallery2 set series2 = '$name' where id = '{$row2['id']}' limit 1";
      mysql_query($query2);
      

    } 
		
		$query = "update series2 set name = '$name' where id = '$id' limit 1";
		
	}
	else
	{
    $query = "insert into series2 (name) values ('$name')";
  }
	mysql_query($query);
	header("location:1dax.php?series2=1&comp=1#a");
	exit;

}



############################################################################### FAQ


if ($_REQUEST['action'] == 'faq')
{
	

	$q = fix($_REQUEST['question']);
	$a = $_REQUEST['answer'];

  $id = $_REQUEST['id'];
  

	
	if ($q == '' || $a == '')
	{
		header("location:1dax.php?faq=1&error=1#a");
		exit;
	}

			
	if ($_REQUEST['delete'] == '1') 
	{
		$query = "delete from faq where id = '" .$_REQUEST['id'] . "' limit 1";
			mysql_query($query);
	
	header("location:1dax.php?faq=1#c");	
	
	}
	else if ($_REQUEST['id'] != '') 
	{
      $query = "update faq set question = '$q', answer = '$a' where id ='$id' limit 1";

	}
	else 
  {
		$query = "insert into faq(question, answer) values('$q', '$a')";	
		
	}
	mysql_query($query);
	if ($_REQUEST['id'] == '') $id = mysql_insert_id();
	else $id = $_REQUEST['id'];

	

	
	

	header("location:1dax.php?faq=1&comp=1&xid=$id#a");
	exit;

}	





############################################################################### VIDEO POST


if ($_REQUEST['action'] == 'videos')
{
	

	$name = fix($_REQUEST['name']);
	$url = $_REQUEST['url'];
	$url = str_replace("https://", "http://", "$url");
	$vseries = $_REQUEST['vseries'];
  $description = fix($_REQUEST['description']);
  $id = $_REQUEST['id'];
  
  $featured = $_REQUEST['featured'];
  
  if ($featured == 'Yes')
  {
    $query = "update videos set featured = '' where featured = 'Yes'";
    mysql_query($query);
  }
  
  
$parts = explode("&",$url); 
$url = $parts['0'];
$ph = substr($url, 31);

$photo = "http://img.youtube.com/vi/$ph/2.jpg";


	
	if ($name == '' || $url == '')
	{
		header("location:1dax.php?videos=1&error=1#a");
		exit;
	}

			
	if ($_REQUEST['delete'] == '1') 
	{
		$query = "delete from videos where id = '" .$_REQUEST['id'] . "' limit 1";
			mysql_query($query);
	
	header("location:1dax.php?videos=1#c");	
	
	}
	else if ($_REQUEST['id'] != '') 
	{
      $query = "update videos set featured = '$featured', vseries = '$vseries', description = '$description', name = '$name', url = '$url', photo = '$photo' where id ='$id' limit 1";

	}
	else 
  {
		$query = "insert into videos(featured, name, photo, url, description, vseries) values('$featured', '$name', '$photo', '$url', '$description', '$vseries')";	
		
	}
	mysql_query($query);
	if ($_REQUEST['id'] == '') $id = mysql_insert_id();
	else $id = $_REQUEST['id'];

	

	
	

	header("location:1dax.php?videos=1&comp=1&xid=$id#a");
	exit;

}	




############################################################################### VIDEO SECTIONS

if ($_REQUEST['action'] == 'videosec')
{

$name = fix($_REQUEST['name']);
$id = $_REQUEST['id'];
$delete = $_REQUEST['delete'];

if ($name == '')
{
  header("location:1dax.php?videosec=1&error=1#a");
  exit;
}




	if ($delete == '1')
	{
		$query = "delete from videosec where id = '$id' limit 1";		
	}

	else if ($id != '')
	{
		
		$query = "select name, id from videosec where id = '$id'";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		
		$query = "select * from videos where videosec = '{$row['name']}'";
		$result = mysql_query($query);
		

		
		while($row2 = mysql_fetch_array($result))
		{
      $query2 = "update videos set videosec = '$name' where id = '{$row2['id']}' limit 1";
      mysql_query($query2);
      

    } 
		
		$query = "update videosec set name = '$name' where id = '$id' limit 1";
		
	}
	else
	{
    $query = "insert into videosec (name) values ('$name')";
  }
	mysql_query($query);
	header("location:1dax.php?videosec=1&comp=1#a");
	exit;

}



############################################################################### PAGES

if ($_REQUEST['action'] == 'pages')
{

$name = fix($_REQUEST['name']);
$id = $_REQUEST['id'];
$delete = $_REQUEST['delete'];

if ($name == '')
{
  header("location:1dax.php?pages=1&error=1#a");
  exit;
}



	if ($delete == '1')
	{
		$query = "delete from content where id = '$id' limit 1";		
	}

	else if ($id != '')
	{
		
		$query = "update content set name = '$name' where id = '$id' limit 1";
		
	}
	else
	{
    $query = "insert into content (name) values ('$name')";
  }
	mysql_query($query);
	header("location:1dax.php?pages=1&comp=1#a");
	exit;

}



############################################################################### Edit Members

if ($_REQUEST['action'] == 'editmem')
{
  $email = $_REQUEST['email'];
  $pass = $_REQUEST['pass'];
  $sendto = $_REQUEST['sendto'];
  $name = fix($_REQUEST['name']);
  $level = $_REQUEST['level'];
  $delete = $_REQUEST['delete'];
  $id = fix($_REQUEST['id']);
  
  if ($email == '' || $name == '' || $pass == '' || $sendto == '') 
  {
    header("location:1dax.php?editmem=1&error=1#a");
    exit;
  }
  
  if ($delete == '1')
  {
    
    $query = "delete * from times where userid = '$id'";
    mysql_query($query);

    $query = "delete from user where id = '$id' limit 1";
  }
  else if ($_REQUEST['id'] != '')
  {
    $query = "update user set level = '$level', sendto = '$sendto', pass = '$pass', email = '$email', name = '$name' where id ='{$_REQUEST['id']}' limit 1";
		}
		else
		{
      $query = "insert into user (level, sendto, pass, email, name) values('$level', '$sendto', '$pass', '$email', '$name')";
		}
	
	mysql_query($query);
	
	header("location:1dax.php?editmem=1&comp=1#a");
	
}



############################################################################### Account update

if ($_REQUEST['action'] == 'account')
{
  $email = $_REQUEST['email'];
  $pass = $_REQUEST['pass'];
  $sendto = $_REQUEST['sendto'];
  $name = fix($_REQUEST['name']);
  
  $query = "update user set name = '$name', sendto = '$sendto', email = '$email', pass = '$pass' where id ='{$_SESSION['unu2Sup32P4sS']}' limit 1";
	mysql_query($query);
	echo mysql_error();
	header("location:1dax.php?account=1&comp=1#a");
}



############################################################################### Site update

if ($_REQUEST['action'] == 'site')
{
  $email = $_REQUEST['email'];
  $paypal = $_REQUEST['paypal'];
  $name = fix($_REQUEST['name']);
  
  $query = "update site set name = '$name', paypal = '$paypal', email = '$email' where id ='1' limit 1";
	mysql_query($query);
	echo mysql_error();
	header("location:1dax.php?site=1&comp=1#a");
}



############################################################################### SERIES

if ($_REQUEST['action'] == 'series')
{

$name = fix($_REQUEST['name']);
$id = $_REQUEST['id'];
$delete = $_REQUEST['delete'];

if ($name == '')
{
  header("location:1dax.php?series=1&error=1#a");
  exit;
}

if ($name == 'Website Images')
{
  header("location:1dax.php?series=1&error=2#a");
  exit;
}


	if ($delete == '1')
	{
		$query = "delete from series where id = '$id' limit 1";		
	}

	else if ($id != '')
	{
		
		$query = "select name, id from series where id = '$id'";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		
		$query = "select * from gallery where series = '{$row['name']}'";
		$result = mysql_query($query);
		

		
		while($row2 = mysql_fetch_array($result))
		{
      $query2 = "update gallery set series = '$name' where id = '{$row2['id']}' limit 1";
      mysql_query($query2);
      

    } 
		
		$query = "update series set name = '$name' where id = '$id' limit 1";
		
	}
	else
	{
    $query = "insert into series (name) values ('$name')";
  }
	mysql_query($query);
	header("location:1dax.php?series=1&comp=1#a");
	exit;

}




############################################################################### Update Text

if ($_REQUEST['action'] == 'text')
{
  $title = fix($_REQUEST['title']);
  $keywords = fix($_REQUEST['keywords']);
  $description = fix($_REQUEST['description']);
  $text = fix($_REQUEST['text']);
  $id = $_REQUEST['id'];
  $page = $_REQUEST['page'];
  
  $query = "update content set title = '$title', keywords = '$keywords', description = '$description', text = '$text' where id ='$id' limit 1";
	mysql_query($query);
	echo mysql_error();

	
	header("location:1dax.php?text=1&page=$page&comp=1#a");
}


############################################################################### GALLERY POST


if ($_REQUEST['action'] == 'gallery')
{
	

	$name = fix($_REQUEST['name']);
  $series = fix($_REQUEST['series']);
  $description = fix($_REQUEST['description']);
  $id = $_REQUEST['id'];
	
	if ($name == '')
	{
		header("location:1dax.php?gallery=1&error=1#a");
		exit;
	}

	
	
		if (is_uploaded_file($_FILES['photo']['tmp_name']))
		{
			$ext = getFileExtension($_FILES['photo']['name'],$withperiod = false);
			$fname = "-" . date('U') . rand(0,999) . "." . $ext;
			$ext = strtolower($ext);
			# Do some fucking security checking
			if ($ext == 'jpg' || $ext == 'JPG' || $ext == 'png' || $ext == 'PNG' || $ext == 'gif' || $ext == 'GIF')
			{
        $tay = 'Classy';
			}
			else
			{
        include "templ/header.php";
          echo "<div class='error'>Error! Uploaded File is Not Supported!</div>";
        include "templ/footer.php";
        exit;
			}
			
			$target_path = $base  . "gal/" . $fname;
			$thumb_path = $base  . "gal/tn_" . $fname;
						
			move_uploaded_file($_FILES['photo']['tmp_name'], $target_path);
			
			$imagedata = getimagesize($target_path);
			$width = $imagedata[0];
			$height = $imagedata[1];
		
			$w2 = 640;
			$h2 = round(($w2 * $height) / $width);
			
			resize2($target_path,$target_path,$width,$height,$w2,$h2);
			/*$im2 = ImageCreateTrueColor($w2, $h2);
			$image = ImageCreateFromJpeg($target_path);	
			imagecopyResampled ($im2, $image, 0, 0, 0, 0, $w2, $h2, $width, $height);		
			imageJPEG($im2,$target_path,100);*/
			
			$tw2 = 160;
			$th2 = round($h2 / 4);
			
			resize2($target_path,$thumb_path,$w2,$h2,$tw2,$th2);
			/*$im2 = ImageCreateTrueColor($tw2, $th2);
			$image = ImageCreateFromJpeg($target_path);	
			imagecopyResampled ($im2, $image, 0, 0, 0, 0, $tw2, $th2, $w2, $h2);		
			imageJPEG($im2,$thumb_path,100);*/
			
			if ($_REQUEST['water'] != '')
			{
        $watermark = imagecreatefrompng('watermark.png');
        $watermark_width = imagesx($watermark);
        $watermark_height = imagesy($watermark);
        $image = imagecreatetruecolor($watermark_width, $watermark_height);
        if ($ext == 'png') $image = imagecreatefrompng($target_path);
        else if ($ext == 'gif') $image = imagecreatefromgif($target_path);
        else if ($ext == 'jpg') $image = imagecreatefromjpeg($target_path);
        else  $image = imagecreatefromjpeg($target_path);
        $size = getimagesize($target_path);
        $dest_x = $size[0] - $watermark_width - 5;
        $dest_y = $size[1] - $watermark_height - 5;
        imagecopy($image, $watermark, $dest_x , $dest_y, 0, 0, $watermark_width, $watermark_height);
        imagejpeg($image, $target_path,100);
			}

			$upped = true;
		}
		else $fname = "none.jpg";
					
			
	if ($_REQUEST['delete'] == '1') 
	{
		$query = "select photo from gallery where id = '" . $_REQUEST['id'] . "'";
		$result = mysql_query($query);
		$photoname = mysql_result($result,0,0);
		if ($photoname != 'none.jpg')
			{
		unlink($base . "gal/" . $photoname);
		unlink($base . "gal/tn_" . $photoname);
		}
		$query = "delete from gallery where id = '" .$_REQUEST['id'] . "' limit 1";
			mysql_query($query);
	echo mysql_error();
	if ($_REQUEST[''] == '') $id = mysql_insert_id();
	else $id = $_REQUEST['id'];
	header("location:1dax.php");	
	
	}
	else if ($_REQUEST['id'] != '') 
	{
		if ($upped) 
		{
			$query = "select photo from gallery where id = '" . $_REQUEST['id'] . "'";
			$result = mysql_query($query);
			$photoname = mysql_result($result,0,0);
			
			if ($photoname != 'none.jpg')
			{
				unlink($base . "gal/" . $photoname);
				unlink($base . "gal/tn_" . $photoname);
			}
			$query = "update gallery set description = '$description', photo = '$fname', name = '$name', series = '$series' where id ='" . $_REQUEST['id'] . "' limit 1";
		
		}
		else $query = "update gallery set description = '$description', name = '$name', series = '$series' where id ='" . $_REQUEST['id'] . "' limit 1";

	}
	else 
	{
		
		
		$query = "insert into gallery(name, photo, series, description) values('$name', '$fname', '$series', '$description')";	
		
	}
	mysql_query($query);
	echo mysql_error();
	if ($_REQUEST['id'] == '') $id = mysql_insert_id();
	else $id = $_REQUEST['id'];

	

	
	

	header("location:1dax.php?gallery=1&comp=1#a");

}	



############################################ End Gallery upEdit



############################################################################################ NAVIGATION

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin Center</title>
<script type='text/javascript'>
function doUpload()
{
	$("#uploadForm").hide();
	$("#pleaseWait").show();	
}
</script>
<?

include "templ/header.php";

$queryx = "select * from user where id = {$_SESSION['unu2Sup32P4sS']}";
$resultx = mysql_query($queryx);
$dax = mysql_fetch_array($resultx);
$rank = $dax['level'];
echo "<div class='comp'>ADMINISTRATION CENTER <i>V.7.4 by unu<b>2</b></i></div>";
echo "Logged in as: <a href='1dax.php?account=1'><b>{$dax['name']}</b></a> : Level <b><font color='#FF0000'>{$dax['level']}</b> Access</font> [ <a href='0dax.php?logout=1'><i>Logout</i></a> ]";


echo "<hr /><center>";

echo "<img src='graphics/a-account.png' alt='' /> ";
echo " [ <a href='1dax.php?account=1#a'><b>Your Account</b></a> ]";
if ($rank >= '7') echo " [ <a href='1dax.php?site=1#a'> <b>Site Settings</b></a> ]";
if ($rank >= '7') echo " [ <a href='1dax.php?editmem=1#a'> <b>Modify Members</b></a> ]";
if ($rank >= '7') echo " [ <a href='1dax.php?logins=1#a'> <b>Login Times</b></a> ]";
echo "<br />";


echo "<img src='graphics/a-photo.png' alt='' /> ";
echo " [ <a href='1dax.php?series=1#a'> <b>Galleries</b></a> ] ";
echo " [ <a href='1dax.php?gallery=1#a'><b>Add/Edit Photos</b></a> ] ";
echo "<br />";

echo "<img src='graphics/a-videos.png' alt='' /> ";
echo "  [ <a href='1dax.php?videos=1#a'> <b>Add/Edit YouTube Videos</b></a> ]<br />";


echo "<font color='FF0000' face='impact' size='6'>&#36;</font>";
echo " [ <a href='1dax.php?series2=1#a'> <b>Store Sections</b></a> ] ";
echo " [ <a href='1dax.php?gallery2=1#a'><b>Add/Edit Products</b></a> ] ";
echo "<br />";



echo "<img src='graphics/a-notes.png' alt='' /> ";

$ghj = "select id, name from content order by name";
$tyu = mysql_query($ghj);
while ($gfd = mysql_fetch_array($tyu))
{
  echo "[<a href='1dax.php?text=1&page={$gfd['name']}#a'><b>{$gfd['name']}</b></a>] ";
}



echo "</center><hr /><br /><br />";

   ?>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins: "iespell,paste,fullscreen,table,visualchars,spellchecker",
	content_css : "templ/stylesadmin.css",
	theme_advanced_buttons1 : "undo,redo,|,copy,paste,pastetext,pasteword,|,forecolor,bold,italic,underline,fontselect,fontsizeselect,|,spellchecker",
	theme_advanced_buttons2 : "image,|,link,|,charmap,|,tablecontrols,|,cleanup,removeformat,code,|,fullscreen",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});
</script>

<?

############################################################################################ Account Update


if ($_REQUEST['account'])
{

  echo "<a name='a'>&nbsp;</a><div class='nam'>Account Settings</div>";
  if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";

  $query = "select * from user where id = '" . $_SESSION['unu2Sup32P4sS'] . "'";
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
  ?>

  <form action='1dax.php' method='post'>
  <input type='hidden' name='action' value='account'>
  Your Login Name: <input type='text' name='email' value='<? echo $row['email']; ?>'><br /><br />
  Your Password : <input type='text' name='pass' value='<? echo $row['pass']; ?>'><br /><br />
  Your Email : <input type='text' name='sendto' size='50' value='<? echo $row['sendto']; ?>'><br /><br />
  Your Full Name : <input type='text' name='name' size='40' value='<? echo $row['name']; ?>'><br /><br />
  <input type='submit' name='submit' value='Update Account info'>
  </form>
  <?
}

############################################################################################ Site Update


if ($_REQUEST['site'])
{

  echo "<a name='a'>&nbsp;</a><div class='nam'>Site Settings</div>";
  if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";

  $query = "select * from site where id = '1'";
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
  ?>

  <form action='1dax.php' method='post'>
  <input type='hidden' name='action' value='site'>
  Site Email: <input type='text' name='email' size='50' value='<? echo $row['email']; ?>'><br /><br />
  PayPal Account Email (optional): <input type='text' name='paypal' size='40' value='<? echo $row['paypal']; ?>'><br /><br />

  <input type='submit' name='submit' value='Update Site Settings'>
  </form>
  <?
}


############################################################################################ GALLERIES
if ($_REQUEST['series'])
{
   echo "<a name='a'></a><div class='nam'>Add/Edit a Gallery</div><br />";
   
   if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";
   if ($_REQUEST['error'] == '1') echo "<div class='error'>ERROR! You must have a Name for this Gallery</div><br />";
   if ($_REQUEST['error'] == '2') echo "<div class='error'>ERROR! You may not Edit this Gallery</div><br />";
   
   ## NEW OR EDIT
   if ($_REQUEST['id']) echo "<div class='error'>NOW IN EDITING MODE</div><br />"; 
   else echo "<div class='create'>NOW CREATING NEW, CLICK BELOW TO EDIT</div><br />"; 
   ##
   
   if ($_REQUEST['id'])
   {
   $query = "select * from series where id = '{$_REQUEST['id']}'";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
   }
    ?>
    <a name='a'>&nbsp;</a>
    <form action='1dax.php' method='post'>
    Gallery Title: <input type="text" name="name" value="<? echo $row['name']; ?>" />
    <?
    if ($_REQUEST['id']) echo "Delete? <input type='checkbox' name='delete' value='1'> <br />"; ?>
    <input type='hidden' name='action' value='series'>
    <input type='hidden' name='id' value='<? echo $row['id']; ?>'>
    <input type='submit' name='submit' value='Go'>
    </form><br /><hr /><br />
    <?  
  
    $query = "select * from series order by name";
    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result))
    {
      echo " [ <a href='1dax.php?series=1&id={$row['id']}#a'>{$row['name']}</a> ] ";
    }

}



############################################################################################ EDIT GALLERY
if ($_REQUEST['gallery'])
{
   echo "<a name='a'>&nbsp;</a><div class='nam'>Add Edit Photographs</div><br />";
   if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";
   if ($_REQUEST['error']) echo "<div class='error'>ERROR!</div><br />";
   
   ## NEW OR EDIT
   if ($_REQUEST['id']) echo "<div class='error'>NOW IN EDITING MODE  - <a href='?gallery=1#a'><font size='3'>Return to Create New?</a></font></div><br />"; 
   else echo "<div class='create'>NOW CREATING NEW, <a href='#b'>CLICK HERE TO EDIT</a></div><br />"; 
   ##
   if ($_REQUEST['id'] != '')
{
  $query = "select * from gallery where id = '{$_REQUEST['id']}'";
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
}   
  ?>

    <form action='1dax.php' method='post' id='uploadForm' enctype='multipart/form-data'>

  <? if ($_REQUEST['id']) { ?><img src='gal/tn_<? echo $row['photo']; ?>'></a><br>
  <? }
  else echo "<br /><b>Upload new photo</b><br />"; ?>

  <div><b><? if ($_REQUEST['id']) { ?>Overwrite<? } ?> Photo</b>: <input type='file' name='photo'></div><br>

<div> <b>  Add Watermark to Image?</b>
    <select name='water'>
    <option value='1'>Yes</option>  
    <option value=''>No</option>
    </select>
    
    </div><br /><br />
    

  <div> <b><font color='#FF0000'>*</font>  <? if ($_REQUEST['id']) { ?>Change<? } ?> Photo Title</b>: <input type='text' name='name' value="<? if ($_REQUEST['id']) echo $row['name']; ?>"></div><br>
  

  
  

    <div> <b> <? if ($_REQUEST['id']) { ?>Change<? } ?> Gallery</b>: 
    <select name='series'>
    <? if ($_REQUEST['id']) { ?><option value="<? echo $row['series']; ?>"><? echo $row['series']; ?></option><? } ?> 
    <?
      $query = "select id, name from series order by name";
      $dax = mysql_query($query);
      while($qwe = mysql_fetch_array($dax))
      {
        echo "<option value='{$qwe['name']}'>{$qwe['name']}</option>";
      }
    ?>
    
    </select>
    
    </div><br /><br />
    
    
   
    
    
    
    <b>Description</b>:<br />
    <font size='1'><i>NOTE!!! <b>If PASTING from a WORD DOC. Use the icon below </b><i>6th from right, top row, <b> Not </b>CTRL + V</i></i></font><br />
    <textarea rows="4" cols="50" name='description'><? echo str_replace('"','&quot;',$row['description']); ?></textarea><br /><br />


  <? if ($_REQUEST['id']) { ?>
  <div><b><u>Delete</u></b> above <b>Photo</b>? <input type='checkbox' name='delete' value='1'></div><br>
  <? } ?>
  

  <input type='hidden' name='id' value='<? echo $_REQUEST['id']; ?>'>
  <input type='hidden' name='action' value='gallery'>
  <? if ($_REQUEST['id'] == '') { ?><input type='submit' name='submit' onclick="doUpload()" value='Click to Upload Photo'><? } ?>
  <? if ($_REQUEST['id']) { ?><input type='submit' name='submit' onclick="doUpload()" value='Click to SUBMIT CHANGES'><br><br> <? echo "<a href='1dax.php?gallery=1'>"; ?> <b><i>Return to Create New?</b></i></a><? } ?>
  
</form><br />
<div id='pleaseWait' style='display:none; padding:30px;'><img src='graphics/loading.gif' alt='' border='0' /> <b>Working..</b> Please wait wile we are processing your image (Do Not Navigate Away During this time!).</div>
<br />
<?  

echo "<a name='b'></a><hr />Click Group Below to <b>Edit or Delete</b> Associated Entries:<br /><br />";
  
  $query2 = "select * from series order by name";
  $resu2 = mysql_query($query2);
  while($row2 = mysql_fetch_array($resu2))
  {
    echo "<div class='nam2'><a href='?gallery=1&seriesx={$row2['name']}#c'>{$row2['name']}</a></div>";
    
  }
  
  
  if ($_REQUEST['seriesx'])
  {
    echo "<a name='c'></a><br /><hr />";
    
    $query = "select id, photo from gallery where series = '{$_REQUEST['seriesx']}' order by id desc";
    $resu = mysql_query($query);
    if (mysql_numrows($resu) < 1) echo "<div class='error'>Sorry, no entries were found under <b>{$_REQUEST['seriesx']}</b> in the Database!</div>";
    else echo "Click Image to bring entry up for Editing or Deletion<br /><br />";
    while($row = mysql_fetch_array($resu))
    {
      echo " <a href='1dax.php?id={$row['id']}&gallery=1#a'><img src='gal/tn_{$row['photo']}' alt='' width='80' /></a>  ";
    }
  }

}

############################################################################# END EDIT GALLERY



############################################################################################ EDIT TEXT
if ($_REQUEST['text'])
{
   
   $page = $_REQUEST['page'];
   
   echo "<a name='a'>&nbsp;</a><div class='nam'>Edit your $page Page</div><br />";
   if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";

  $query = "select * from content where name = '$page'";
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
  
  $tap = $row['text'];
  
   
  ?>
    <i>This is How Your Page will Look on Google</i><br />
    <table border='1' cellpadding='20'><tr><td bgcolor='#FFFFFF'>
    <font color='#0000FF' size='3'><u><? echo $row['title']; ?></u></font><br />
    <font color='#00CC00' size='2'>www.YourURL.com</font><br />
    <font color='#000000' size='1'><? echo $row['description']; ?></font></td></tr></table><br /><br />
    
    <form action='1dax.php' method='post'>
    
    <b><? echo $page; ?> Page Title</b>: <i>(24 Words MAX).</i><br />
    <input type='text' name='title' style='width:500px;' value="<? echo $row['title']; ?>" /><br /><br />
    
    <b><? echo $page; ?> Keywords</b>:<br />
    <i>(Separate Words by Commas ie, Keyword1, Keyword2) (25 Words MAX).</i><br />
    <input type='text' name='keywords' style='width:500px;' value="<? echo $row['keywords']; ?>" /><br /><br />
    
    <b><? echo $page; ?> Description</b>:<br />
    <i>(No Special Characters).</i><br />
    <input type='text' name='description' style='width:500px;' value="<? echo $row['description']; ?>" /><br /><br />

<font size='1'><i>NOTE!!! <b>If PASTING from a WORD DOC. Be sure to use the icon below (Not CTRL + V).</b>.</i></font><br />
  <textarea rows="20" cols="113" name='text'><? echo str_replace('"','&quot;',$tap); ?></textarea><br />

  <input type='hidden' name='id' value='<? echo $row['id']; ?>' />
  <input type='hidden' name='action' value='text' />
  <input type='hidden' name='page' value='<? echo $page; ?>' />
  <input type='submit' name='submit' value='Click to Update Webpage Content'>
</form><br />


<i></b>You can Drag and Drop the Below images into your Text Area.<br />Once within the Text Area, Click the iamge again to re-size.</i><br /><br />
<center>

<?

$query = "select id, photo from gallery where series = 'Website Images' order by id desc";
    $resu = mysql_query($query);
    while($rowx = mysql_fetch_array($resu))
    {
      echo "<img src='gal/{$rowx['photo']}' alt='' width='40' />  ";
    }
 
echo "</center>";


}



############################################################################# Login Times
if ($_REQUEST['logins'])
{
  echo "<a name='a'>&nbsp;</a><div class='nam'>Employee Login Times</div><br />";
  $query = "select * from times order by date desc";
  $result = mysql_query($query);
  while($row = mysql_fetch_array($result))
  {
    $query2 = "select * from user where id = '{$row['userid']}'";
    $result2 = mysql_query($query2);
    $row2 = mysql_fetch_array($result2);
    
    $date = ($row['date'] - '7200');
    
    echo "<b>{$row2['name']}</b><br />";
    echo date("m-d-Y h:i a",$date);
    echo "<br /><hr /><br />";
    
  }
}



############################################################################################ edit MEMBERS


if ($_REQUEST['editmem'])
{

  echo "<a name='a'>&nbsp;</a><div class='nam'>Add Edit Website Admin's</div>";
  if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";
   if ($_REQUEST['error']) echo "<div class='error'>ERROR! All Fields Required!</div><br />";
   
   
      ## NEW OR EDIT
   if ($_REQUEST['id']) echo "<div class='error'>NOW IN EDITING MODE</div><br />"; 
   else echo "<div class='create'>NOW CREATING NEW, CLICK BELOW TO EDIT</div><br />"; 
   ##
   if ($_REQUEST['id'] != '')
{
  $query = "select * from user where id = '{$_REQUEST['id']}'";
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
}   

  
  
  $query = "select * from user where id = '{$_REQUEST['id']}'";
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
  

          ?>
      <form action='1dax.php' method='post'>
        



        <input type='hidden' name='action' value='editmem'>
        Their Desired Login Name: <input type='text' name='email' value='<? echo $row['email']; ?>'><br /><br />
        Their Desired Password : <input type='text' name='pass' value='<? echo $row['pass']; ?>'><br /><br />
        Their Email Address: <input type='text' name='sendto' size='50' value='<? echo $row['sendto']; ?>'><br /><br />
        Their Full Name (First, Middle, Last) : <input type='text' name='name' size='40' value='<? echo $row['name']; ?>'><br /><br />
        
      Their Security Clearance Level:<br />
      <select name='level'>
      <? if ($_REQUEST['id']) echo "<option value='{$row['level']}'>{$row['level']}</option>"; ?>
      <option value='1'>1</option>
      <option value='2'>2</option>
      <option value='3'>3</option>
      <option value='4'>4</option>
      <option value='5'>5</option>
      <option value='6'>6</option>
      <option value='7'>7</option>
      </select>

        <br /><br />
        
        <? if ($_REQUEST['id']) echo "<div><b><u>Delete</u></b> above <b>Employee</b>? <input type='checkbox' name='delete' value='1'></div><br /><br />"; ?>
        
        <input type='hidden' name='id' value='<? echo $_REQUEST['id']; ?>'>
        <input type='submit' name='submit' value='Submit Changes'>
        </form>
        
        <br /><hr />
        
        <?
  
  echo "<a name='edit'>&nbsp;</a>Click below to <b>Edit or Delete Website Admin's</b>:<br /><br />";
  $query = "select * from user order by name";
  $resu = mysql_query($query);
  while($row = mysql_fetch_array($resu))
  {
    echo "<div class='nam2'><a href='1dax.php?id={$row['id']}&editmem=1#a'><b>{$row['name']}</b></a></div>";
  }

    
   echo "<hr /><br />";
}

############################################################################################ PAGES
if ($_REQUEST['pages'])
{
   echo "<div class='nam'>Add/Edit PAGES</div><br />";
   
   if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";
   if ($_REQUEST['error'] == '1') echo "<div class='error'>ERROR! You must have a Name for this Page</div><br />";
   if ($_REQUEST['error'] == '2') echo "<div class='error'>ERROR! You may not Edit this Gallery</div><br />";
   
   ## NEW OR EDIT
   if ($_REQUEST['id']) echo "<div class='error'>NOW IN EDITING MODE</div><br />"; 
   else echo "<div class='create'>NOW CREATING NEW, CLICK BELOW TO EDIT</div><br />"; 
   ##
   
   if ($_REQUEST['id'])
   {
   $query = "select id, name from content where id = '{$_REQUEST['id']}'";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
   }
    ?>
    <a name='a'>&nbsp;</a>
    <form action='1dax.php' method='post'>
    Page Title: <input type="text" name="name" value="<? echo $row['name']; ?>" />
    <?
    if ($_REQUEST['id']) echo "Delete? <input type='checkbox' name='delete' value='1'> <br />"; ?>
    <input type='hidden' name='action' value='pages'>
    <input type='hidden' name='id' value='<? echo $row['id']; ?>'>
    <input type='submit' name='submit' value='Go'>
    </form><br /><hr /><br />
    <?  
  
    $query = "select id, name from content order by name";
    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result))
    {
      echo " [ <a href='1dax.php?pages=1&id={$row['id']}#a'>{$row['name']}</a> ] ";
    }

}




############################################################################################ VIDEO SECTIONS
if ($_REQUEST['videosec'])
{
   echo "<div class='nam'><a name='a'>&nbsp;</a>Add/Edit a Video Section</div><br />";
   
   if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";
   if ($_REQUEST['error'] == '1') echo "<div class='error'>ERROR! You must have a Name for this Section</div><br />";
   if ($_REQUEST['error'] == '2') echo "<div class='error'>ERROR! You may not Edit this Gallery</div><br />";
   
   ## NEW OR EDIT
   if ($_REQUEST['id']) echo "<div class='error'>NOW IN EDITING MODE</div><br />"; 
   else echo "<div class='create'>NOW CREATING NEW, CLICK BELOW TO EDIT</div><br />"; 
   ##
   
   if ($_REQUEST['id'])
   {
   $query = "select * from videosec where id = '{$_REQUEST['id']}'";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
   }
    ?>
    
    <form action='1dax.php' method='post'>
    Video Section Title: <input type="text" name="name" value="<? echo $row['name']; ?>" />
    <?
    if ($_REQUEST['id']) echo "Delete? <input type='checkbox' name='delete' value='1'> <br />"; ?>
    <input type='hidden' name='action' value='videosec'>
    <input type='hidden' name='id' value='<? echo $row['id']; ?>'>
    <input type='submit' name='submit' value='Update Video Sections'>
    </form><br /><hr /><br />
    <?  
  
    $query = "select * from videosec order by name";
    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result))
    {
      echo " [ <a href='1dax.php?videosec=1&id={$row['id']}#a'>{$row['name']}</a> ] ";
    }

}




  ############################################################################################################################## Video time
  
if ($_REQUEST['videos'])
{
  
  echo "<a name='a'>&nbsp;</a><div class='nam'>Add Edit YouTube Videos</div>";

   if ($_REQUEST['error']) echo "<div class='error'>ERROR! All Fields Required!</div><br />";
  
  $queryx = "select * from videos where id = '{$_REQUEST['id']}'";
  $resultx = mysql_query($queryx);
  $row = mysql_fetch_array($resultx);
  
                if ($_REQUEST['comp'] == '1') 
        {
          echo "<div style='font-size: 30px;'>Update Complete!</div><br />";
          $queryx = "select * from videos where id = '{$_REQUEST['xid']}'";
          $resultx = mysql_query($queryx);
          $rowb = mysql_fetch_array($resultx);
          echo "<center><img src='{$rowb['photo']}' alt='' border='0' /></center><hr /><br />";
        }
      ## NEW OR EDIT
   if ($_REQUEST['id']) echo "<div class='error'>NOW IN EDITING MODE</div><br />"; 
   else echo "<div class='create'>NOW CREATING NEW, CLICK BELOW TO EDIT</div><br />"; 
   ##   

    
    echo "<form action='1dax.php?action=videos' method='post'>";
    
    if ($_REQUEST['id']) echo "<img src='{$row['photo']}' alt='' border='0' />";
    if ($_REQUEST['id']) echo " <b>Delete</b>? <input type='checkbox' name='delete' value='1'><br />";
    

    echo "<br /><b>YouTube</b> URL<br />";
    echo "<input type='text' size='70'  name='url' value='{$row['url']}' />";
    echo "<br />";
    echo "<font size='2'><b>NOTE:</b> <i>Must be hosted on <a href='http://www.YouTube.com' target='_Blank'><b>YouTube</b></a> and will look like <font color='#FF0000'>http://www.youtube.com/watch?v=MsOXMn8r5EY</font></i></font><br />";

    

    echo "<b>Video Title:</b><br />";
    echo "<input type='text' size='70' name='name' value='{$row['name']}' />";

    
    echo "<br /><br />";
    
    echo "<i>Optional: Get better visibility by writing a short description.</i><br />";
    echo "<input type='text' size='70' name='description' value='{$row['description']}' />";

    
    if ($_REQUEST['id']) echo "<input type='hidden' name='id' value='{$_REQUEST['id']}' />"; 

    
    
    echo "<div class='clearme'></div>";
    
    echo "<div><b><u>Feature Video</u>? <input type='checkbox' name='featured' ";
    if ($row['featured'] == 'Yes') echo "checked ";
    echo "value='Yes'></div><br /><br />";
  
    if ($_REQUEST['id']) { ?>
  <div><b><u>Delete</u></b> above <b>Video</b>? <input type='checkbox' name='delete' value='1'></div><br />
  <? } 
  
   
      echo "<input type='submit' name='submit' value='Submit'>";
    echo "</form>";
    
  
  echo "<br /><hr /><br />Click Below to Bring Videos up for Editing or Deletion<br /><br />";

    $queryx = "select * from videos order by id desc";
    $resultx = mysql_query($queryx);
    while ($rowx = mysql_fetch_array($resultx))
    {
      
      echo "<div style='width:160px; border:1px solid #FFFFFF; height:200px; float:left; margin-right:10px; margin-left:20px; margin-bottom:10px;'>\n";
        echo "<div style='padding-top:10px; text-align:center;'>\n";

          echo "<a name='{$rowx['id']}'>&nbsp;</a>";
          echo "<a href='?videos=1&id={$rowx['id']}&dyno=1#a'><img style='max-width:160px; max-height:140px;' src='{$rowx['photo']}' alt='{$rowx['name']}' title='{$rowx['name']}' /></a>";
        echo "</div>";

        echo "<div style='padding-top:7px; padding-left:20px;'>";    
          $name = substr($rowx['name'],0,20);
          echo "<a href='?videos=1&id={$rowx['id']}&dyno=1#a'><b>$name</b></a>";

        echo "</div>"; 

      echo "</div>";
    }
  

}




############################################################################################ FAQ
if ($_REQUEST['faq'])
{
   echo "<a name='a'></a><div class='nam'>Add/Edit your F.A.Q</div><br />";
   
   if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";
   if ($_REQUEST['error'] == '1') echo "<div class='error'>ERROR! You must have a Q and A</div><br />";
   
   ## NEW OR EDIT
   if ($_REQUEST['id']) echo "<div class='error'>NOW IN EDITING MODE</div><br />"; 
   else echo "<div class='create'>NOW CREATING NEW, CLICK BELOW TO EDIT</div><br />"; 
   ##
   
   if ($_REQUEST['id'])
   {
   $query = "select * from faq where id = '{$_REQUEST['id']}'";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
   }
    ?>
    <a name='a'>&nbsp;</a>
    <form action='1dax.php' method='post'>
    Question: <input type="text" name="question" size='60' value="<? echo $row['question']; ?>" /><br /><br />
    
        <b>Answer</b>:<br />
    <font size='1'><i>NOTE!!! <b>If PASTING from a WORD DOC. Use the icon below </b><i>6th from right, top row, <b> Not </b>CTRL + V</i></i></font><br />
    <textarea rows="4" cols="50" name='answer'><? echo str_replace('"','&quot;',$row['answer']); ?></textarea><br /><br />
    
    
    <?
    if ($_REQUEST['id']) echo "Delete? <input type='checkbox' name='delete' value='1'> <br />"; ?>
    <input type='hidden' name='action' value='faq'>
    <input type='hidden' name='id' value='<? echo $row['id']; ?>'>
    <input type='submit' name='submit' value='Update FAQ'>
    </form><br /><hr /><br />
    <?  
  
    $query = "select * from faq order by question";
    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result))
    {
      echo " [ <a href='1dax.php?faq=1&id={$row['id']}#a'><u>{$row['question']}</u></a> ]<br />";
    }

}






############################################################################################ Store Sections
if ($_REQUEST['series2'])
{
   echo "<a name='a'></a><div class='nam'>Add/Edit Store Sections</div><br />";
   
   if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";
   if ($_REQUEST['error'] == '1') echo "<div class='error'>ERROR! You must have a Name for this Section</div><br />";
   if ($_REQUEST['error'] == '2') echo "<div class='error'>ERROR! You may not Edit this Section</div><br />";
   
   ## NEW OR EDIT
   if ($_REQUEST['id']) echo "<div class='error'>NOW IN EDITING MODE</div><br />"; 
   else echo "<div class='create'>NOW CREATING NEW, CLICK BELOW TO EDIT</div><br />"; 
   ##
   
   if ($_REQUEST['id'])
   {
   $query = "select * from series2 where id = '{$_REQUEST['id']}'";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
   }
    ?>
    <a name='a'>&nbsp;</a>
    <form action='1dax.php' method='post'>
    Store Section Title: <input type="text" name="name" value="<? echo $row['name']; ?>" />
    <?
    if ($_REQUEST['id']) echo "Delete? <input type='checkbox' name='delete' value='1'> <br />"; ?>
    <input type='hidden' name='action' value='series2'>
    <input type='hidden' name='id' value='<? echo $row['id']; ?>'>
    <input type='submit' name='submit' value='Go'>
    </form><br /><hr /><br />
    <?  
  
    $query = "select * from series2 order by name";
    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result))
    {
      echo " [ <a href='1dax.php?series2=1&id={$row['id']}#a'>{$row['name']}</a> ] ";
    }

}







############################################################################################ EDIT PRODUCTS
if ($_REQUEST['gallery2'])
{
   echo "<a name='a'>&nbsp;</a><div class='nam'>Add Edit Products</div><br />";
   if ($_REQUEST['comp']) echo "<div class='comp'>Update Complete</div><br />";
   if ($_REQUEST['error'] == '1') echo "<div class='error'>ERROR! You must have a NAME</div><br />";
   if ($_REQUEST['error'] == '2') echo "<div class='error'>ERROR! You must have a PRICE and WEIGHT</div><br />";
   
   ## NEW OR EDIT
   if ($_REQUEST['id']) echo "<div class='error'>NOW IN EDITING MODE  - <a href='?gallery2=1#a'><font size='3'>Return to Create New?</a></font></div><br />"; 
   else echo "<div class='create'>NOW CREATING NEW, <a href='#b'>CLICK HERE TO EDIT</a></div><br />"; 
   ##
   if ($_REQUEST['id'] != '')
{
  $query = "select * from gallery2 where id = '{$_REQUEST['id']}'";
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
}   
  ?>

    <form action='1dax.php' method='post' id='uploadForm' enctype='multipart/form-data'>

  <? if ($_REQUEST['id']) { ?><img src='gal/tn_<? echo $row['photo']; ?>'></a><br>
  <? }
  else echo "<br /><b>Upload new photo</b><br />"; ?>

  <div><b><? if ($_REQUEST['id']) { ?>Overwrite<? } ?> Photo</b>: <input type='file' name='photo'></div><br>

<div> <b><font color='#FF0000'>*</font>  Add Watermark to Image?</b>
    <select name='water'>
    <option value='1'>Yes</option>  
    <option value=''>No</option>
    </select>
    
    </div><br />
    
    

<div> <b><font color='#FF0000'>*</font> In Stock?</b>
    <select name='onoff'>
    <? if ($_REQUEST['id']) { ?><option value="<? echo $row['onoff']; ?>"><? echo $row['onoff']; ?></option><? } ?> 
    <option value='Yes'>Yes</option>  
    <option value='Out'>Out of Stock</option>
    </select>
    
    </div><br />
    

  <div> <b><font color='#FF0000'>*</font>  <? if ($_REQUEST['id']) { ?>Change<? } ?> Product Name</b>: <input type='text' name='name' value="<? if ($_REQUEST['id']) echo $row['name']; ?>"></div><br />
  
  <div> <b><font color='#00FF00'>*</font>  <? if ($_REQUEST['id']) { ?>Change<? } ?> SKU</b>: <input type='text' name='sku' value="<? if ($_REQUEST['id']) echo $row['sku']; ?>"></div><br />
  
  
  <div> <b><font color='#FF0000'>*</font>  <? if ($_REQUEST['id']) { ?>Change<? } ?> Price</b>: (NUMBERS ONLY!) <b>&#36;</b><input type='text' name='price' value="<? if ($_REQUEST['id']) echo $row['price']; ?>"></div><br />
  
  <div> <b><font color='#FF0000'>*</font>  <? if ($_REQUEST['id']) { ?>Change<? } ?> Weight</b>: (NUMBERS ONLY!) <input type='text' name='weight' value="<? if ($_REQUEST['id']) echo $row['weight']; ?>"><b>.Lbs</b></div><br />
  

  
  

    <div> <b> <? if ($_REQUEST['id']) { ?>Change<? } ?> Store Section Assignment</b>: 
    <select name='series2'>
    <? if ($_REQUEST['id']) { ?><option value="<? echo $row['series2']; ?>"><? echo $row['series2']; ?></option><? } ?> 
    <?
      $query = "select id, name from series2";
      $dax = mysql_query($query);
      while($qwe = mysql_fetch_array($dax))
      {
        echo "<option value='{$qwe['name']}'>{$qwe['name']}</option>";
      }
    ?>
    
    </select>
    
    </div><br /><br />
    
    <b>Description</b>:<br />
    <font size='1'><i>NOTE!!! <b>If PASTING from a WORD DOC. Use the icon below </b><i>6th from right, top row, <b> Not </b>CTRL + V</i></i></font><br />
    <textarea rows="4" cols="50" name='description'><? echo str_replace('"','&quot;',$row['description']); ?></textarea><br /><br />


  <? if ($_REQUEST['id']) { ?>
  <div><b><u>Delete</u></b> above <b>Product</b>? <input type='checkbox' name='delete' value='1'></div><br>
  <? } ?>
  

  <input type='hidden' name='id' value='<? echo $_REQUEST['id']; ?>'>
  <input type='hidden' name='action' value='gallery2'>
  <? if ($_REQUEST['id'] == '') { ?><input type='submit' name='submit' onclick="doUpload()" value='Click to Upload Product'><? } ?>
  <? if ($_REQUEST['id']) { ?><input type='submit' name='submit' onclick="doUpload()" value='Click to SUBMIT CHANGES'><br><br> <? echo "<a href='1dax.php?gallery2=1'>"; ?> <b><i>Return to Create New?</b></i></a><? } ?>
  
</form><br />
<div id='pleaseWait' style='display:none; padding:30px;'><img src='graphics/loading.gif' alt='' border='0' /> <b>Working..</b> Please wait wile we are processing your stuff (Do Not Navigate Away During this time!).</div>
<br />
<?  

echo "<a name='b'></a><hr />Click Store Sections Below to <b>Edit or Delete</b> Associated Entries:<br /><br />";
  
  $query2 = "select * from series2 order by name";
  $resu2 = mysql_query($query2);
  while($row2 = mysql_fetch_array($resu2))
  {
    echo "<div class='nam2'><a href='?gallery2=1&series2x={$row2['name']}#c'>{$row2['name']}</a></div>";
    
  }
  
  
  if ($_REQUEST['series2x'])
  {
    echo "<a name='c'></a><br /><hr />";
    
    $query = "select id, photo from gallery2 where series2 = '{$_REQUEST['series2x']}' order by id desc";
    $resu = mysql_query($query);
    if (mysql_numrows($resu) < 1) echo "<div class='error'>Sorry, no entries were found under <b>{$_REQUEST['series2x']}</b> in the Database!</div>";
    else echo "Click Image to bring entry up for Editing or Deletion<br /><br />";
    while($row = mysql_fetch_array($resu))
    {
      echo " <a href='1dax.php?id={$row['id']}&gallery2=1#a'><img src='gal/tn_{$row['photo']}' alt='' width='80' /></a>  ";
    }
  }

}





include "templ/footer.php";

?>