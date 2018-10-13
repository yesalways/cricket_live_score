<?php
include "../Database/dbConnect.php";
$matchid = $_POST['matchid'];
//echo $uname,$pwd,$ground;
//echo $uname;
$con = getConnection();
$qry = mysqli_query($con, "UPDATE `matches_2018` set `status`='active' where `matchid`='$matchid' ");
mysqli_close($con);
if ($qry != 0) {
    echo "<script>window.open('admin.php', '_self');window.alert('match activated');</script>";
} else {
    echo "<script>window.open('admin.php', '_self');window.alert('match not activated');</script>";
}
