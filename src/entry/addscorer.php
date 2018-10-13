<?php
 include("../Database/dbConnect.php");
 $uname=$_POST['uname'];
 $pwd=$_POST['pwd'];
 $ground=$_POST['ground'];
 //echo $uname,$pwd,$ground;

 $con=getConnection();
 $qry=mysqli_query($con,"INSERT into `login` values('$uname','$pwd','$ground','0')");
 mysqli_close($con);
 if($qry!=0){
  echo "<script>window.open('admin.php', '_self');window.alert('saved successfully');</script>";
 }
  else echo "<script>window.open('admin.php', '_self');window.alert('not saved');</script>";

 ?>