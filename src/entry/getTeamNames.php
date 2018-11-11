<?php
date_default_timezone_set('Asia/Calcutta');

function getTeamNames($teamid, $matchid){
 $con = getConnection();
 $qry = mysqli_query($con, "SELECT `playerid` from `batting` where `teamid` = '$teamid' and `matchid`='$matchid'  ");
 $data[0]="";
 $i=0;
 // echo mysqli_affected_rows($con);
 while($res = mysqli_fetch_array($qry)){
  $data[$i++] = $res[0];
  }
 return $data;
}

function getBowlersNames($teamid, $matchid){
 $con = getConnection();
 $qry2 = mysqli_query($con, "SELECT `playerid` from `bowling` where `teamid` = '$teamid' and `matchid`='$matchid'");
 $data[0]="";
 $i=1;
 // echo mysqli_affected_rows($con);
 while($res2 = mysqli_fetch_array($qry2)){
  $data[$i++] = $res2[0];
  }
  $data[0]=$i-1;
 return $data;
}