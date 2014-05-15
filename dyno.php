<?
include "templ/secure.php";
session_start();
include "db.php";

$pieces = explode("_", $p);
$l = $pieces[1]; 


$l = str_replace("-", " ", "$l");

############## Check what System they are using, Location, Location and game or Member

include "index.php";

