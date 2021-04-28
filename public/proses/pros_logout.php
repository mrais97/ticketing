<?php
require("../config.php");
$roleuser = $_SESSION['role'];
$uiduser = $_SESSION['uid'];
$username = $_SESSION['username'];
session_destroy();
header("location:../index.php");
?>