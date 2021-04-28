<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$uid=$_POST['uid'];
$email=$_POST['email'];
$div=$_POST['div'];
$jab=$_POST['jab'];
$flag=$_POST['flag'];
$sql="UPDATE t_user
SET email='$email',bagian='$div',jabatan='$jab',flag = '$flag',update_date= CAST(NOW() AS DATETIME)
WHERE user_uid = '$uid'";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else
{
    echo "failed";
}
?>