<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$tickid=$_POST['tickid'];
$catdet=$_POST['catdet'];
$prio=$_POST['prio'];
$prob=$_POST['prob'];
$sql="UPDATE trans
SET id_detail = '$catdet', problem= '$prob',priority='$prio', updated_at = CAST(NOW() AS DATETIME)
WHERE id_trans = '$tickid'";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else
{
    echo "failed";
}
?>