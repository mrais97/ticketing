<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$ticknumber=$_POST['ticknumber'];
$flag=$_POST['flag'];
$ket=$_POST['ket'];

if ($flag=='1') {
    $sql = "UPDATE t_transaksi
SET flag = '$flag',detail='$ket',updated_at = CAST(NOW() AS DATETIME),finish_date = CAST(NOW() AS DATETIME)
WHERE no_ticket= '$ticknumber' ";
}
else{
    $sql = "UPDATE t_transaksi
SET flag = '$flag',detail='$ket',updated_at = CAST(NOW() AS DATETIME),hold_date = CAST(NOW() AS DATETIME)
WHERE no_ticket= '$ticknumber' ";
}

if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else
{
    echo "failed";
}
?>