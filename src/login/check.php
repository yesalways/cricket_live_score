<?php
session_start();
include("../Database/dbConnect.php");
if(isset($_POST['username']) && isset($_POST['password']) )
{
$u = trim($_POST['username']);
$p = trim($_POST['password']);
$con = getConnection();
$qry1 = mysqli_query($con, "select * from `login` where `user_id` = '$u'");
$flag=0;
$type="";
while($res1 = mysqli_fetch_array($qry1))
{
 if($res1[1]==$p){
	 $gid=$res1[2];
     $flag=1;
     $q=mysqli_query($con, "update `login` set `status` = 1 where `user_id`='$u' ");
     if($u=='admin')
     {
         $_SESSION['username'] = $u;
       echo "<script>window.open('../entry/admin.php', '_self');</script>";
     }
     break;
 }
}
if($flag)
{
 $_SESSION['username'] = $u;
 $gid = substr($u,4,1);
 $qry2 = mysqli_query($con, "select * from `matches_2018` where `matchid` like '____$gid%' and `status` like 'active'");
 if(mysqli_affected_rows($con)==0) $_SESSION['matchid']=0;	// to check this error
    while($res2 = mysqli_fetch_array($qry2))
    {
    // echo "<br>",$res2['matchid'], " " , $res2['status'];
    $_SESSION['matchid'] = $res2['matchid']; 
    }
    $matchid=$_SESSION['matchid'];
  $qry= mysqli_query($con, "select `inning1start`,`inning2start` from `matches_2018` where `matchid` like '$matchid' and `status` like 'active' ");
  $inning1=null;$inning2=null;
  while($res=mysqli_fetch_array($qry))
   {
       $inning1=$res['inning1start'];
       $inning2=$res['inning2start'];
   }
   if($inning1!=null||$inning2!=null)
   {
      /*$qrytr=mysqli_query($con,"START TRANSACTION");
      echo mysqli_error($con); 
      $qrytr1=mysqli_query($con,"SAVEPOINT rs");
      echo mysqli_error($con); 
     */
     echo "<script>window.open('../entry/test1.php', '_self');</script>";
   }
   else 
     echo "<script>window.open('../entry/', '_self');</script>";
 }
else	{
       echo "<script>window.alert('login credentials incorrect')";
       echo "<script>window.open('../login/', '_self');</script>";
}
	// header('Location:/OBE_WT');
}
?>