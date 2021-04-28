<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$catdetid=$_POST['catdetid'];
$catdetname=$_POST['catdetname'];
$catid=$_POST['catid'];
$flag=$_POST['flag'];
$sql="UPDATE t_category_detail
SET detail_category_name = '$catdetname',flag='$flag',id_category='$catid',updated_at = CAST(NOW() AS DATETIME)
WHERE id='$catdetid'";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else
{
    echo "failed";
}
?>