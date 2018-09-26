<?php
// source .. from srtrophy/entry/test1.php


date_default_timezone_set('Asia/Calcutta');
session_start();
include('getTeamNames.php');
include("../Database/dbConnect.php");
$con = getConnection();
$matchid = $_SESSION['matchid'];
$inning = $_SESSION['inning'];
$batsmanid = $_POST['batsman'];
$bowlerid = $_POST['bowler'];
$score = $_POST['runs'];
$extratype = $_POST['extras']; 
$outtype = $_POST['wickets'];
$fielderid=null;
$fielderid=$_POST['fielder_catch'];

//echo "innning :",$inning,"score :",$score,"extratype : ",$extratype,"outtype:",$outtype;
 //echo $matchid;

$overqry=mysqli_query($con,"select total,overs,balls  from `$matchid`  where  `inning`=$inning order by `thetime` desc limit 1  ");
while($row=mysqli_fetch_array($overqry))
{
    $total=$row['total'];
    $overs=$row['overs'];
    $balls=$row['balls'];
}
// echo $overs,".",$balls;

            if($balls==5)//database returned balls
            {
                $balls=-1; $overs++;
            }
                
              if($overs==$_SESSION['overs']&&$balls==0)
                {
                  if($inning==1)
                      {
                          $qry0 = mysqli_query($con, "UPDATE `matches_2018` set `inning1end`=NOW() where `inning1end` is NULL and `matchid` = '$matchid'");
                          $qry2=mysqli_query($con,"INSERT into  $matchid(`inning`,`batsmanid`,`bowlerid`,`total`,`overs`,`balls`,`score`) values ('2','.','.','0','0','0','0') ");
                          //dummy record for start of second innnings
                          $qry4 = mysqli_query($con, "UPDATE `matches_2018` set `inning2start`=NOW() where `inning2start` is NULL and `matchid` = '$matchid'");
                          echo "<script>window.open('test1.php', '_self')</script>";
                        }
                  else if($inning==2)
                  {
                      $qr2= mysqli_query($con,"UPDATE `match_scores` set `scoreA`='$total' where `match_id`='$matchid'");
                      $qry0 = mysqli_query($con, "UPDATE `matches_2018` set `inning2end`=NOW() where `inning2end` is NULL and `matchid` = '$matchid'");
                      //echo "<script>window.open('logout.php', '_self')</script>";
                  }
                }
             
          


 if($extratype=="fair"&&$outtype=="Notout")
 {
    $balls++;
    $total=$total+$score;
    $qry2 = mysqli_query($con, "INSERT into `$matchid` (`inning`, `batsmanid`, `bowlerid`,`total`,`overs`,`balls`, `score`, `extra`, `extratype` ) 
                                                 values ('$inning', '$batsmanid', '$bowlerid','$total','$overs','$balls','$score','0' ,'$extratype')");
 }
 else if($extratype=="fair"&&$outtype!="Notout")
 {
    if($outtype=="Bowled"||$outtype=="Lbw")
    {
        $balls++;
        $qry2 = mysqli_query($con, "INSERT into `$matchid` (`inning`, `batsmanid`, `bowlerid`,`total`,`overs`,`balls`, `score`, `extra`, `extratype`,`outtype` )
                                                    values ('$inning', '$batsmanid', '$bowlerid','$total','$overs','$balls','0','0' ,'$extratype','$outtype')");                                    
    }
    else if($outtype=="Caught"||$outtype=="Stumped")
    {
        $balls++;
        $qry2 = mysqli_query($con, "INSERT into `$matchid` (`inning`, `batsmanid`, `bowlerid`,`total`,`overs`,`balls`, `score`, `extra`, `extratype`,`outtype`,`fielderid` )
                                                    values ('$inning', '$batsmanid', '$bowlerid','$total','$overs','$balls','0','0' ,'$extratype','$outtype','$fielderid')");   
    }
    else if($outtype=="Runout")
    {
        $balls++;
        $total=$total+$score;
        $qry2 = mysqli_query($con, "INSERT into `$matchid` (`inning`, `batsmanid`, `bowlerid`,`total`,`overs`,`balls`, `score`, `extra`, `extratype`,`outtype`,`fielderid` )
                                                    values ('$inning', '$batsmanid', '$bowlerid','$total','$overs','$balls','$score','0' ,'$extratype','$outtype','$fielderid')");
    }
 }
 else if($extratype=="Wide"&&$outtype=="Notout") 
 {
     $total=$total+$score+1;
    $qry2 = mysqli_query($con, "INSERT into `$matchid` (`inning`, `batsmanid`, `bowlerid`,`total`,`overs`,`balls`, `score`, `extra`, `extratype` ) 
     values ('$inning', '$batsmanid', '$bowlerid','$total','$overs','$balls','$score','1' ,'$extratype')");  
 }
 else if($extratype=="Wide"&&$outtype!="Notout") 
 {
     if($outtype=="Stumped"||$outtype=="Runout")
     {
      $total=$total+$score+1;
        $qry2 = mysqli_query($con, "INSERT into `$matchid` (`inning`, `batsmanid`, `bowlerid`,`total`,`overs`,`balls`, `score`, `extra`, `extratype`,`outtype`,`fielderid` ) 
        values ('$inning', '$batsmanid', '$bowlerid','$total','$overs','$balls','$score','1' ,'$extratype','$outtype','$fielderid')");
    } 
 }
 
 else if(($extratype=="Bye"||$extratype=="Legbye")&&$outtype=="Notout")
 {
     $balls++;
     $total=$total+$score;
     $qry2 = mysqli_query($con, "INSERT into `$matchid` (`inning`, `batsmanid`, `bowlerid`,`total`,`overs`,`balls`, `score`, `extra`, `extratype`) 
                                                values ('$inning', '$batsmanid', '$bowlerid','$total','$overs','$balls','$score','.','$extratype')");       
 }
else if(($extratype=="Bye"||$extratype=="Legbye") && $outtype!="Notout")
{
    if($outtype=="Stumped"||$outtype=="Runout")
    {
       $balls++;
       $total=$total+$score;
       $qry2 = mysqli_query($con, "INSERT into `$matchid` (`inning`, `batsmanid`, `bowlerid`,`total`,`overs`,`balls`, `score`, `extra`, `extratype`,`outtype`,`fielderid` ) 
       values ('$inning', '$batsmanid', '$bowlerid','$total','$overs','$balls','$score','.' ,'$extratype','$outtype','$fielderid')");

   }   
}
else if($extratype=="Noball"&&$outtype=="Notout") 
{
    $total=$total+$score+1;
   $qry2 = mysqli_query($con, "INSERT into `$matchid` (`inning`, `batsmanid`, `bowlerid`,`total`,`overs`,`balls`, `score`, `extra`, `extratype` ) 
    values ('$inning', '$batsmanid', '$bowlerid','$total','$overs','$balls','$score','1' ,'$extratype')");
   
}

else if($extratype=="Noball"&&$outtype!="Notout") 
{
    if($outtype=="Runout")
    {
       $total=$total+$score+1;
       $qry2 = mysqli_query($con, "INSERT into `$matchid` (`inning`, `batsmanid`, `bowlerid`,`total`,`overs`,`balls`, `score`, `extra`, `extratype`,`outtype`,`fielderid` ) 
       values ('$inning', '$batsmanid', '$bowlerid','$total','$overs','$balls','$score','1' ,'$extratype','$outtype','$fielderid')");
   }
    
}
   
//deciding winners should be last in this file
$qr=mysqli_query($con,"SELECT * from `match_scores` where `match_id`='$matchid'");
while($row=mysqli_fetch_array($qr))
{
    $teamA=$row['teamA'];
    $teamB=$row['teamB'];
    $scoreA=$row['scoreA'];
    $scoreB=$row['scoreB'];
    $wicketsA=$row['wicketsA'];
    $wicketsB=$row['wicketsB'];
    $oversA=$row['oversA'];
    $oversB=$row['oversB'];
}
if($wicketsA==10)
{
    $qry0 = mysqli_query($con, "UPDATE `matches_2018` set `inning1end`=NOW() where `inning1end` is NULL and `matchid` = '$matchid'");
    $qry2=mysqli_query($con,"INSERT into  $matchid(`inning`,`batsmanid`,`bowlerid`,`overs`,`balls`,`score`) values ('2','.','.','0','0','0') ");
    //dummy record for start of second innnings
    $qry4 = mysqli_query($con, "UPDATE `matches_2018` set `inning2start`=NOW() where `inning2start` is NULL and `matchid` = '$matchid'");
}
else if($wicketsB==10)
{
    $qry0 = mysqli_query($con, "UPDATE `matches_2018` set `inning2end`=NOW() where `inning2end` is NULL and `matchid` = '$matchid'"); 
    if($scoreA==$scoreB)
        $qry4 = mysqli_query($con, "UPDATE `matches_2018` set `remarks`='match tied' where `matchid` = '$matchid'");
    else 
       {
            $qry3 = mysqli_query($con, "UPDATE `matches_2018` set `winner_teamid`='$teamA' where `matchid` = '$matchid'");  
            $qry4 = mysqli_query($con, "UPDATE `matches_2018` set `remarks`='match tied' where `matchid` = '$matchid'");
          //  $qry0 = mysqli_query($con, "UPDATE `matches_2018` set `inning2end` where `inning2end` is NULL and `matchid` = '$matchid'");
            echo "<script>window.open('logout.php', '_self')</script>";
       }
}
else if($scoreB>$scoreA)
{
    $qry3 = mysqli_query($con, "UPDATE `matches_2018` set `winner_teamid`='$teamB' where `matchid` = '$matchid'");
    $qry0 = mysqli_query($con, "UPDATE `matches_2018` set `inning2end`=NOW() where `inning2end` is NULL and `matchid` = '$matchid'");
    echo "<script>window.open('logout.php', '_self')</script>";
}
else if($oversB==$_SESSION['overs'])
{
    if($scoreA>$scoreB)
    {
        $qry3 = mysqli_query($con, "UPDATE `matches_2018` set `winner_teamid`='$teamA' where `matchid` = '$matchid'");
    }
    else if($scoreA==$scoreB)
    {
        $qry4 = mysqli_query($con, "UPDATE `matches_2018` set `remarks`='match tied' where `matchid` = '$matchid'");
    }
    $qry0 = mysqli_query($con, "UPDATE `matches_2018` set `inning2end`=NOW() where `inning2end` is NULL and `matchid` = '$matchid'");
    echo "<script>window.open('logout.php', '_self')</script>";
}

echo "<script>window.open('test1.php','_self')</script>";

?>
