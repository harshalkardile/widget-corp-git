<?php 
require("constants.php");


$connection= mysqli_connect(SRVR, USR, PSWD);
if(!$connection){
    die("Database connection failed:". mysql_error());
}

$db_select = $connection->select_db(DBNME);
// $db_select = mysqli_select_db("", $connection); 
if(!$db_select){
    die("database selection failed:" . mysql_error());
}

?>