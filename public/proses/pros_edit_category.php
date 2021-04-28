<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$catid=$_POST['catid'];
$catname=$_POST['catname'];
$catname = preg_replace('/[^A-Za-z0-9\w\ ]/i', '', $catname);
$flag=$_POST['flag'];
$sql="UPDATE t_category
SET category_name = '$catname', flag= '$flag',update_at = CAST(NOW() AS DATETIME)
WHERE id = $catid";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else
{
    echo "failed";
}
?>