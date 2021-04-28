<?php
require_once('config.php');

$username 	= mysqli_real_escape_string($con, $_POST['username']);
$pass 		= sha1($_POST['pass']);
$sql 		= "SELECT * FROM ticket_staging.mr_user_login WHERE user_uname = '$username' AND user_passwd = '$pass'";
$result 	= mysqli_query($con, $sql);
$hitungData = mysqli_fetch_array($result);
$id 		= $hitungData['user_uid'];
$hitung 	= mysqli_num_rows($result);

if ($hitung>=1) {																	//cek username pass
    $sql1 		= "SELECT * FROM ticket_staging.t_role WHERE us_uid = '$id'";
    $result1 	= mysqli_query($con, $sql1);
    $data1 		= mysqli_fetch_array($result1);
    $hitung1 	= mysqli_num_rows($result1);

    if ($hitung1 >= 1) {  															//cek apa role ada
        $role2 	 = $data1['us_role'];
        $id2 	 = $data1['us_uid'];
    } else {
		$sql2 	 = "INSERT INTO ticket_staging.t_role (us_uid,us_role) SELECT $id,1 FROM ticket_staging.t_role"; // <--- katakan padaku kenapa nyimpan ke table, apakah ini table utk kebutuhan auditrail ??
        if ($con->query($sql2) === TRUE) {
            $sql3 		= "SELECT * FROM ticket_staging.t_role WHERE us_uid = '$id'";
            $result2 	= mysqli_query($con, $sql3);
            $data2 		= mysqli_fetch_array($result2);
            $id2 		= $data2['us_uid'];
            $role2 		= $data2['us_role'];
        } else {
            echo "failed";
        }
    }

    $_SESSION['role'] 		= $role2;
    $_SESSION['uid'] 		= $id2;
    $_SESSION['username'] 	= $username;
    $_SESSION['pass'] 		= $pass;
	$_SESSION['csrf_token'] = substr(sha1(time()), 0, 16);

    $arr = array(
				"status" 	=> $hitung,
				"role" 		=> $role2,
				"uid" 		=> $id2,
				"username" 	=> $username,
				"pass" 		=> $pass
    );
    header('Content-type: application/json');
    echo json_encode($arr);
} else {
    echo 0;
};

?>