<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$fulname = $_POST['fulname'];
$username = $_POST['username'];
$pass = sha1('qwerty123');
$email = $_POST['email'];
$bagian = $_POST['bagian'];
$jab = $_POST['jab'];
$bagianpreg = preg_replace('/[^A-Za-z0-9\w\ ]/i', '', $bagian);
$jabpreg = preg_replace('/[^A-Za-z0-9\w\ ]/i', '', $jab);
    $sql = "INSERT INTO t_user 
(username,pass, id_role,email ,full_name,bagian,jabatan,flag,create_date) 
SELECT '$username','$pass','1','$email','$fulname','$bagianpreg','$jabpreg', '1',CAST(NOW() AS DATETIME)";
    if ($conn->query($sql) === TRUE) {
        echo "data inserted";
    } else {
        echo "failed";

};
?>