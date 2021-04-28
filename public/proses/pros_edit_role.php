<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$uid=$_POST['uid'];
$uname=$_POST['uname'];
$role=$_POST['role'];
$sql="UPDATE t_role
SET us_role= '$role'
WHERE us_uid = $uid";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else
{
    echo "failed";
}
?>