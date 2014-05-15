<?
set_time_limit(0); 

############## VARIABLES ##########################################################################

# DATABASE CONNECTION INFORMATION
$db_user			= "neonyen5_";
$db_pass			= "";
$db_name			= "neonyen5_";
$db_host			= "localhost";

# PATH ON SERVER TO ROOT OF SITE
$base 				= "/home/neonyen5/public_html//";



########## NO MORE EDITS BELOW THIS LINE ##########################################################


### CONNECT TO DATABASE ###########################################################################
if ($db_user != '')
{
	mysql_connect($db_host,$db_user,$db_pass);
	@mysql_select_db($db_name) or die( "Unable to select database");
}
###################################################################################################


###################################################################################################
### ARRAY FUNCTIONS ###############################################################################
###################################################################################################

function getArrayNext($array,$current,$loop = true)
{
	# FIND AND RETURN THE NEXT ITEM IN AN ARRAY
	# Parameters:
	# $array	= array; the array of items to parse
	# $current	= string; the currently selected item
	# $loop		= boolean (true/false); if true, will return first item at end of array
	#			  if false will not return anything at end of array
	#
	# Example: 			echo getArrayNext(array('red','green','blue'),'red');
	# Example Output:	"green"
	foreach ($array as $item)
	{
		if ($flag) return $item;
		if ($item == $current) $flag = true;
		else $flag = false;
	}
	return $array[0];
}

function war($input)
{
	# STRIP OUT ANYTHING EXCEPT LETTERS AND NUMBERS
	# Parameters:
	# $input	= string; text to clean
	#
	# Example:			echo cleanstring("This is'nt what:: you think!");
	# Example Output:	"This isnt what you think"
	return preg_replace('/[^A-Za-z0-9- _@.]/', '', $input);
}

###################################################################################################
### STRING FUNCTIONS ##############################################################################
###################################################################################################

function numberToWords($number) 
{ 
    # CONVERT INTEGER TO WORD FORMAT
	# Example Input: 	$str = "23";
	# Example: 			echo numberToWords($str);
	# Example Output:	"Twenty-Three"
    
    if (($number < 0) || ($number > 999999999)) throw new Exception("Number is out of range");

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) $res .= convert_number($Gn) . " Million"; 
    if ($kn) $res .= (empty($res) ? "" : " ") . convert_number($kn) . " Thousand"; 
    if ($Hn) $res .= (empty($res) ? "" : " ") . convert_number($Hn) . " Hundred"; 
    
    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) $res .= " and "; 
        if ($Dn < 2) $res .= $ones[$Dn * 10 + $n]; 
        else 
        { 
            $res .= $tens[$Dn]; 
            if ($n) $res .= "-" . $ones[$n]; 
        } 
    } 

    if (empty($res)) $res = "zero"; 
   	return $res; 
} 

function fix($str)
{
	# MYSQL CORRECTION FOR SINGLE QUOTES
	# Example Input: 	$str = "Jon's Test";
	# Example: 			echo fix($str);
	# Example Output:	"Jon''s Test"
	$str = str_replace("'","''",stripslashes($str));
	return $str;
}

function cleanstring($input)
{
	# STRIP OUT ANYTHING EXCEPT LETTERS AND NUMBERS
	# Parameters:
	# $input	= string; text to clean
	#
	# Example:			echo cleanstring("This is'nt what:: you think!");
	# Example Output:	"This isnt what you think"
	return preg_replace('/[^A-Za-z0-9- _@]/', '', $input);
}

function qfix($str)
{
	# JAVASCRIPT CORRECTION FOR DOUBLE QUOTES
	# Example Input:	$str = 'Jon says "Hello"';
	# Example: 			echo "<input type=\"text\" name=\"test\" value=\"".qfix($str)."\" />";
	# Example Output:	<input type="text" name="test" value="Jon says &quot;Hello&quot;" />";
	$str = str_replace('"',"&quot;",$str);
	return $str;
}

function jsfix($str)
{
	# JAVASCRIPT CORRECTION FOR SINGLE QUOTES
	# Example Input:	$str = "Jon's Test";
	# Example:			document.getElementById('test').innerHTML(\"".jsfix($str)."\");
	# Example Output:	document.getElementById('test').innerHTML("Jon&rsquo;s Test");
	$str = str_replace("'","&rsquo;",$str);
	return $str;
}

function brfix($str)
{
	# PHP FUNCTION TO CORRECTLY SHOW TEXTAREA HTML CONTENT MINUS BR HTML
	# Example Input:	$str = "Line One<br>Line Two<Br />Line Three";
	# Example:			echo brfix($str);
	# Example Output:	"Line One\nLine Two\nLine Three"
	str_replace(array("<br>","<br />","<BR>","<BR />","<Br>","<bR>","<Br />","<bR />"),"\n",$str);
	return $str;
}

function brshow($str)
{
	# PHP FUNCTION TO CONVERT NEW LINES TO HTML BR
	# Example Input:	$str = "Line One\nLineTwo\nLine Three";
	# Example:			echo brshow($str);
	# Example Output:	"Line One<br />Line Two<br />Line Three"
	$str = str_replace("\n","<br />",$str);
	return $str;
}

function getContent($page,$makelinks = false)
{
	# PHP Function to get page text from 'content' database table
	# Parameters:
	# $page 		= string; matches page field in `content` table
	# $makelinks 	= boolean (true/false); convert web and email links in text to html (true) 
	# Returns null if $page not found in table and creates entry in table
	$query = "select body from content where page='{$page}'";
	$result = mysql_query($query);
	if (mysql_numrows($result) > 0) 
	{
		$str = mysql_result($result,0,0);
		if ($makelinks) $str = makelinks($str);
		return $str;
	}
	else 
	{
		$query = "insert into content (page) values ('".fix($page)."')";
		mysql_query($query);
		return null;
	}
}

function getField($field,$table,$id,$wherefield = 'id')
{
	# PHP Function to get a single field from a table
	# Parameters:
	# $field		= string; the field to retrieve
	# $table		= string; the table name to retrieve the field from
	# $id			= integer; the identifying information to search by
	# $wherefield	= string; the field to search by
	#
	# Example #1: $str = getField('firstname','contactlist',7)
	# Example #1 Query: select `firstname` from `contactlist` where `id`='7'
	#
	# Example #2: $str = getField('firstname','contactlist','lastname','Smith')
	# Example #2 Query: select `firstname` from `contactlist` where `lastname`='Smith'
	#
	# Returns null if no match found, errors are hidden
	$query = "select `$field` from `$table` where `{$wherefield}` = '$id'";
	$result = mysql_query($query);
	if (mysql_numrows($result) > 0) return mysql_result($result,0,0);
	else return null;
}

function makelinks($text)
{
	# AUTO-CREATE LINKS FROM WEB ADDRESSES AND EMAIL LINKS
	# Example Input: 	$str = "Hello, jon@aol.com, click www.yahoo.com to go to yahoo";
	# Example:			echo makelinks($str);
	# Example Output:	"Hello, <a href='mailto:jon@aol.com'>jon@aol.com</a>, click <a href='http://www.yahoo.com'>www.yahoo.com</a> to go to yahoo"
	$text = html_entity_decode($text);
	$text = " ".$text;
	$text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
			'<a href="\\1" target=_blank>\\1</a>', $text);
	$text = eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
			'<a href="\\1" target=_blank>\\1</a>', $text);
	$text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
	'\\1<a href="http://\\2" target=_blank>\\2</a>', $text);
	$text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',
	'<a href="mailto:\\1" target=_blank>\\1</a>', $text);
	return $text;
}

##########################################################################################################
### FILE FUNCTIONS #######################################################################################
##########################################################################################################

function getdirsize($path)
{
	# GET SIZE OF FOLDER AND SUBFOLDERS, RETURN IN BYTES
	# Parameters:
	# $path	= string; path to folder
	#
	# Example:			echo getdirsize("/images");
	# Example Output:	"6283743"
	$result=explode("\t",exec("du -hs ".$path),2);
	return ($result[1]==$path ? $result[0] : "error");
} 

function getFileExtension($filename,$withperiod = false)
{
	# GET FILE EXTENSION, WITH OR WITHOUT PERIOD
	# Parameters:
	# $filename		= string; filename with no path
	# $withperiod	= boolean (true/false); true returns with a period, false without
	#
	# Example:			echo getfileExtension("testfile.pdf");
	# Example Output:	"pdf"
	$ext = strtolower(strrchr($filename, '.')); 
	if ($withperiod) return $ext;
	else return substr($ext,1);
}

function getCurrentPage($withextension = false)
{
	# GET CURRENT PAGE FILENAME WITHOUT QUERY STRING OR PATH
	# Parameters:
	# $withextension	= boolean (true/false); true returns .php, false does not
	#
	# Example: 			echo getCurrentPage();
	# Example Output:	"index"
	$fullp = str_replace("/","",$_SERVER['SCRIPT_NAME']);
	$pos = strpos($fullp,".");
	$p = substr($fullp,0,$pos);
	if ($withextension) $p .= ".php";
	return $p;
}

function showEnglishFileSize($filesize)
{
	# CONVERT FILESIZE FROM BYTES TO READABLE ENGLISH
	# Parameters:
	# $filesize		= decimal; File size in bytes
	#
	# Example: 			echo showEnglishFileSize(62403938);
	# Example Output:	"62.4 MB"
	$file_size = array_reduce (
		array (" B", " KB", " MB"), create_function (
			'$a,$b', 'return is_numeric($a)?($a>=1024?$a/1024:number_format($a,2).$b):$a;'
		), $filesize);
	return $file_size;
}

function readFolder($dir)
{
	# READ LIST OF FILENAMES FROM FOLDER
	# Parameters:
	# $dir	= string; Full path to folder
	#
	# Example:			$files = readFolder("/home/images");
	# Example Output:	array() [array of filenames]
	$dh  = opendir($dir);
	$dirlist = array();
	while (false !== ($file = readdir($dh))) 
	{
		if ($file != '.' && $file != '..')
		{
			$filelist[] = $file;
		}
	}
	return $filelist;
}

function recursiveRemoveFolder($directory, $empty=FALSE)
{
	# RECURSIVELY REMOVE AND DELETE FOLDERS WITH OPTIONAL FILE DELETION
	# Parameters:
	# $directory	= string; full path to folder
	# $empty		= boolean (true/false); delete all files within folder(s)
	#
	# Example:			recursiveRemoveFolder("/home/images",true);
	# Example Output:	[deletes all folders and files within /home/images folder]
	
	if(substr($directory,-1) == '/') $directory = substr($directory,0,-1);
	if(!file_exists($directory) || !is_dir($directory)) return FALSE;
	elseif(!is_readable($directory)) return FALSE;
	else
	{
		$handle = opendir($directory);
		while (FALSE !== ($item = readdir($handle)))
		{
			if($item != '.' && $item != '..')
			{
				$path = $directory.'/'.$item;
				if(is_dir($path)) recursive_remove_directory($path);
				else unlink($path);
			}
		}
		closedir($handle);
		if($empty == FALSE)
		{
			if(!rmdir($directory)) return FALSE;
		}
		return TRUE;
	}
}

##########################################################################################################
### IMAGE FUNCTIONS ######################################################################################
##########################################################################################################

function resize2($f1,$f2,$w,$h,$w2,$h2)
{
	# RESIZE IMAGE OR MAKE THUMBNAIL
	# Parameters:
	# $f1	= string; input file path
	# $f2 	= string; output file path
	# $w	= integer; input image width
	# $h	= integer; input image height
	# $w2	= integer; output image width
	# $h2	= integer; output image height

	### ImageMagick Version
	$c = exec("/usr/bin/convert -size {$w}x{$h} $f1 -thumbnail {$w2}x{$h2} $f2");
	
	### GD Version
	#$im2 = ImageCreateTrueColor($w2,$h2);
	#$image = ImageCreateFromJpeg($f1);	
	#imagecopyResampled ($im2, $image, 0, 0, 0, 0, $w2, $h2, $w, $h);
	#imageJPEG($im2,$f2,99);
}

function getDPI($filename)
{
    # GET DPI OF JPEG
	# Parameters:
	# $filename	= string; Path to JPEG Image
	#
	# Example:			echo getDPI("test.jpg");
	# Example Output:	array(300,300)
    $a = fopen($filename,'r'); 
    $string = fread($a,20); //open the file and read first 20 bytes.
    fclose($a);

    $data = bin2hex(substr($string,14,4)); //get the value of byte 14th up to 18th
    $x = substr($data,0,4);
    $y = substr($data,4,4);
    return array(hexdec($x),hexdec($y));
} 

function get_exif($img)
{
	# GET EXIF DATA FROM JPEG
	# Parameters:
	# $img		= string; Path to file
	# 
	# Example:			$exif = get_exif("images/test.jpg");
	# Example Output:	array()
	$exifdata = array();
	$exif = exif_read_data($img, 'IFD0');
	if ($exif)
	{
		ini_set('exif.encode_unicode', 'UTF-8');
		$exif = exif_read_data($img, 0, true);
		foreach ($exif as $key => $section) {
			foreach ($section as $name => $val) $exifdata[$key][$section][$name] = $val;
		}
	}
	return $exifdata;
}

function hex2rgb($color)
{
    # CONVERT HEX COLOR TO RGB COLOR ARRAY
	# Parameters:
	# $color	= string; Hex Color eg. "000000"
	#
	# Example:			$rgb = hex2rgb('000000');
	# Example Output:	array(00,00,00);
	$color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return array(0,0,0); }
    $rgb = array();
    for ($x=0;$x<3;$x++){
        $rgb[$x] = hexdec(substr($color,(2*$x),2));
    }
    return $rgb;
}

##########################################################################################################
### DATE FUNCTIONS #######################################################################################
##########################################################################################################
function monthname($n,$dateformat = "F")
{
	# CONVERT MONTH NUMBER INTO ENGLISH
	# Parameters:
	# $n			= integer; 1-12 (Jan-Dec)
	# $dateformat 	= string; date format from php 'date' function
	#
	# Example:			echo monthname(3);
	# Example Output:	"March";
	$timestamp = mktime(0, 0, 0, $n, 1, 2009);
	return date("F", $timestamp);
}


##########################################################################################################
### EMAIL FUNCTIONS ######################################################################################
##########################################################################################################
function email($to,$from,$subject,$msg, $showtemplate = false)
{
	# SEND EMAIL
	# Parameters:
	# $to			= string; email address to send to
	# $from			= string; email address to send from
	# $subject		= string; subject of the email
	# $msg			= string; message body
	# $showtemplate	= boolean (true/false); use header and footer graphics
	global $siteurl;
	if ($showtemplate) $msg = "<table width='500' border='0' cellpadding='5' cellspacing='5' style='border:1px solid #dbdbdb;'><tr><td><img src='http://{$siteurl}/images/emailheader2.jpg' alt='' /></td></tr><tr><td><div style='line-height:18px;'><font size='2' face='Arial, Helvetica, sans-serif'>{$msg}</font></div></td></tr><tr><td><a href='http://{$siteurl}'><img border='0' src='http://{$siteurl}/images/emailfooter.jpg' alt='' /></a></td></tr></table>\n";
	
	$headers = "From: $from\r\n" . "MIME-Version: 1.0\r\n" . "Content-Type: text/html;\r\n";
	$sendit = @mail($to,$subject,$msg,$headers);
}

function emailattached($to,$from,$subject,$message,$files,$showtemplate = false)
{
	# SEND EMAIL WITH ATTACHMENTS
	# Parameters:
	# $to			= string; email address to send to
	# $from			= string; email address to send from
	# $subject		= string; subject of the email
	# $msg			= string; message body
	# $files		= array; array of strings, full path to files
	# $showtemplate	= boolean (true/false); use header and footer graphics
	global $base;
	$headers = "From: $from";
	$semi_rand = md5(time());
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
	$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
	$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
	$message .= "--{$mime_boundary}\n";
	for($x=0;$x<count($files);$x++){
		$file = fopen($base . $files[$x],"rb");
		$data = fread($file,filesize($base . $files[$x]));
		fclose($file);
		$data = chunk_split(base64_encode($data));
		$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" .
		"Content-Disposition: attachment;\n" . " filename=\"$files[$x]\"\n" .
		"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
		$message .= "--{$mime_boundary}\n";
	}
	$ok = @mail($to, $subject, $message, $headers);
}

##########################################################################################################
### GEOGRAPHIC FUNCTIONS ######################################################################################
##########################################################################################################
function convertToLatLong($address)
{
	# CONVERT A STRING LOCATION TO LATITUDE AND LONGITUDE
	# Parameters:
	# $address		= string; address to convert
	#
	# RETURNS array with Latitude and Longitude
	
	$f = implode("",file("http://rpc.geocoder.us/service/csv?address=".urlencode($address)));
	list($lat,$long,$junk) = explode(",",$f);
	return array($lat,$long);
}
?>