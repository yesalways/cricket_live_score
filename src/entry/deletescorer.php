<?php
include "../Database/dbConnect.php";
$uname = $_POST['uname'];
//echo $uname,$pwd,$ground;
echo $uname;
$con = getConnection();
$qry = mysqli_query($con, "DELETE from `login` where `user_id`='$uname' ");
mysqli_close($con);
if ($qry != 0) {
    echo "<script>window.open('admin.php', '_self');window.alert('deleted successfully');</script>";
} else {
    echo "<script>window.open('admin.php', '_self');window.alert('not deleted');</script>";
}
