<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$catid=$_POST['catid'];
$email=$_POST['email'];
$pass=$_POST['pwd'];
$sql="UPDATE t_user
SET email = '$email', pass= SHA1('$pass'),update_date = CAST(NOW() AS DATETIME)
WHERE username = '$catid'";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else
{
    echo "failed";
}
?>