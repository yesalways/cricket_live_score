<?php
session_start();
include('getTeamNames.php');
include("../Database/dbConnect.php");
include('../Database/useful.php');
$con = getConnection();
$tot=$_POST['toss_teamid'];
$tt=$_POST['tosstype'];
$overs=$_POST['overs'];
if($tot=='0' || $tt=='0' )
{
 echo "<script> window.alert('select toss'); </script>";
   echo "<script>window.open('../entry/', '_self');</script>";
}
else 
{
    $_SESSION['toss_team_id']=$tot;
	$_SESSION['tosstype']=$tt;


    $matchid = $_SESSION['matchid'];
    $team1id = $_SESSION['team1id'];
	$team2id = $_SESSION['team2id'];
	
	$qry0 = mysqli_query($con, "UPDATE `matches_2018` set `toss_teamid`='$tot' where `matchid` = '$matchid'");
	$qry1 = mysqli_query($con, "UPDATE `matches_2018` set `toss_type`='$tt' where  `matchid` = '$matchid'");
	$qry2 = mysqli_query($con, "UPDATE `matches_2018` set `overs`='$overs' where  `matchid` = '$matchid'");
	$current_date_time = Date('Y-m-d h:i:s');
	// echo $current_date_time;

	createtable();
	
	 if(($tot == $team1id) && ($tt=='Bowling') ) {$teamtobat = $team2id; $teamtobowl = $team1id;}
	 else
	 if(($tot == $team1id) && ($tt=='Batting') ) {$teamtobat = $team1id; $teamtobowl = $team2id;}
	 else
	 if(($tot == $team2id) && ($tt=='Bowling') ) {$teamtobat = $team1id; $teamtobowl = $team2id;}
	 else
	 if(($tot == $team2id) && ($tt=='Batting') ) {$teamtobat = $team2id; $teamtobowl = $team1id;}

	// $qrying = mysql_query($con, "select
	$qry0 = mysqli_query($con, "INSERT into  `match_scores` (`match_id`,`teamA`,`teamB`) values ('$matchid','$teamtobat','$teamtobowl')");
	$qry2 = mysqli_query($con, "UPDATE `matches_2018` set `inning1start`=NOW() where `inning1start` is NULL and `matchid` = '$matchid'");
    // teamA is first innings teamB is second innings
	
	//adding players to batting and bowling tables 
	$qry = mysqli_query($con,"SELECT `playerid` from `players` where `teamid`='$team1id'");
	while($res = mysqli_fetch_array($qry))
	{
		$qry0 = mysqli_query($con, "INSERT into  `batting` (`matchid`,`teamid`,`playerid`) values ('$matchid','$team1id','$res[0]')");
	}
	$qry = mysqli_query($con, "SELECT `playerid` from `players` where `teamid`='$team2id'");
	while ($res = mysqli_fetch_array($qry)) 
	{
        $qry0 = mysqli_query($con, "INSERT into  `batting` (`matchid`,`teamid`,`playerid`) values ('$matchid','$team2id','$res[0]')");
    }

    $qry = mysqli_query($con, "SELECT `playerid` from `players` where `teamid`='$team1id' and `bowl_type` NOT LIKE '%None%' ");
	while ($res = mysqli_fetch_array($qry)) 
	{
    	$qry0 = mysqli_query($con, "INSERT into  `bowling` (`matchid`,`teamid`,`playerid`) values ('$matchid','$team1id','$res[0]')");
	}
	$qry = mysqli_query($con, "SELECT `playerid` from `players` where `teamid`='$team2id' and `bowl_type` NOT LIKE '%None%' ");
	while ($res = mysqli_fetch_array($qry)) 
	{
    	$qry0 = mysqli_query($con, "INSERT into  `bowling` (`matchid`,`teamid`,`playerid`) values ('$matchid','$team2id','$res[0]')");
	}


echo "<script>window.open('test1.php','_self')</script>";
    
}
?>