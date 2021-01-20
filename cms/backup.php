<?php
require_once('backup_restore.class.php');

/** config. php **/
$db_host ="premium44.web-hosting.com";
$db_user = "kentkkfp";
$db_pass ="PAAKWASI@123";
$db_name ="kentkkfp_easyskul_db";

//    $hostname = 'premium44.web-hosting.com';
//    $username = 'kentkkfp';
//    $password = 'PAAKWASI@123';
//    $database_name = 'kentkkfp_easyskul_db';
/****************/
include '../includes/school_ini_user_id.php';

$newImport = new backup_restore($db_host,$db_name,$db_user,$db_pass);

$fileName = $initials . "_" . date("Y-m-d_H-i-a") . ".sql";    
// Header description Taken from http://stackoverflow.com/a/10766725
header("Content-disposition: attachment; filename=".$fileName);
header("Content-Type: application/force-download");
//header("Content-Transfer-Encoding: application/zip;\n");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
header("Expires: 0");

if(mysqli_num_rows(mysqli_query($conn,"select * from database_names where school = '$initials'")) == null){
    mysqli_query($conn,"INSERT INTO `database_names` (`id`, `school`, `db_name`) VALUES (NULL, '$initials', '$fileName');");
}else{
    mysqli_query($conn,"update database_name set db_name = '$fileName' where school = '$initials' ");
}
//call of backup function
echo $newImport -> backup(); die();
?>