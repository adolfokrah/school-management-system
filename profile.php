<!DOCTYPE html>
<?php 
//    include 'includes/mysql_connect.php';
//    $school_url=$_GET['school_url'];
//    $url = $school_url;
//    $query = mysqli_query($conn,"select * from school_urls where `URL`='$school_url'");
//
//    if(mysqli_num_rows($query) == 0){
//        $url = $school_url.'.php';
//        echo "<script>window.open('".$url."','_self')</script>";
//        die();
//    }
$school_url = 'adolf';
    
    //echo $school_url;
?>

<html lang="en">
    	<head>
            <?php $school_url = str_replace('_',' ',$school_url);?>
	
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="easyskul">
	<meta name="description" content="<?php echo $school_url;?> is  a good school containing thousands of students.">
	<meta name="keywords" content="school, EASYSKUL, school software, school management system,<?php echo $school_url;?>">
	<meta name="author" content="pectra solutions">
            
    
	<title><?php echo $school_url;?> - Home | EASYSKUL</title>
    <meta property="og:title" content="<?php echo $school_url;?> - Home | EASYSKUL" />
    <meta property="og:url" content="https://easyskul.com/<?php echo $url;?>" /> 
    <meta property="og:description" content="<?php echo $school_url;?> is  a good school containing thousands of students.">
    <meta property="og:image" content="<?php echo 'https://easyskul.com/image_uploads_crests/IMG-eda6b5b7b465d8cdc67fde77be936bbe_2018-Feb-Mon.jpg' ?>"/>
    <meta property="og:type" content="Messiah" />
    <meta property="og:locale" content="en_GB" />
<meta property="og:locale:alternate" content="fr_FR" />
<meta property="og:locale:alternate" content="es_ES" />
    </head>
    <body>
       
        <?php echo $school_url;?>
    </body>
</html>