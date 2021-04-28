<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$div = $_POST['div'];
$email = $_POST['catname'];
echo $email;
$flag = $_POST['flag'];
$sql1 = "SELECT KSLDIV FROM ticket_staging.mr_ksldiv WHERE ID_KSLDIV= '$div'";
$result1 = mysqli_query($conn, $sql1);
$data1 = mysqli_fetch_array($result1);
$namadiv = $data1['KSLDIV'];

//if (!isset($email) || trim($email) == '') {
//    echo '<script language="javascript">';
//    echo 'alert("message successfully sent")';
//    echo '</script>';
//} else {
    $sql = "INSERT INTO 
        t_divisi (ID, Nama_div,Email_div, Flag, kode_div) 
        SELECT MAX(ID)+1, '$namadiv','$email', '$flag','$div' FROM t_divisi";
    if ($conn->query($sql) === TRUE) {
        echo "data inserted";
    } else {
        echo "failed";
    }
//};
echo $sql;
?>