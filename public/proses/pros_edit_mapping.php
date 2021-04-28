<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$picid=$_POST['picid'];
$flag=$_POST['flag'];
$sql="UPDATE t_mapping_pic
SET flag = '$flag',updated_t = CAST(NOW() AS DATETIME)
WHERE id='$picid'";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else
{
    echo "failed";
}
?>