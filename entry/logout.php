<?php
session_start();
include("../Database/dbConnect.php");
if(isset($_SESSION['username']))
{
	$u=$_SESSION['username'];
	$con = getConnection();
	// echo "Thank you... ", $_SESSION['username'] ," logged out successfully..";
	$q=mysqli_query($con, "update `login` set `status` = 0 where `user_id`='$u' ");
	$_SESSION['username']="";
	session_destroy();
	mysqli_close($con);
}
 echo "<script> window.open('../login/', '_self')</script>";
?>