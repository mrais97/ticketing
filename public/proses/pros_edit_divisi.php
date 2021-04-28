<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$catid=$_POST['catid'];
$creator=$_POST['creator'];
$catname=$_POST['catname'];
$flag=$_POST['flag'];
$sql="UPDATE t_divisi
SET Email_div = '$catname', Flag= '$flag'
WHERE ID = $creator";
echo $sql;
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else
{
    echo "failed";
}
?>