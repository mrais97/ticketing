<?php
require ("../config.php");

$postCategory=$_POST['category'];
$postdiv=$_POST['div'];
$postcategory_detail=$_POST['category_detail'];
$postPic=$_POST['pic'];
$tgl=date("Y-m-d hh:mm:ss");
$sql=mysqli_query($con,"INSERT INTO t_mapping_pic VALUES ('','$postcategory_detail','$postPic','$tgl','$tgl','1','$postdiv')");
//header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
header("Location: ../vw/vw_mapping.php");
//echo "<meta http-equiv='refresh' content='0'>";
//$(location).attr('href', 'vw_role.php');


?>
