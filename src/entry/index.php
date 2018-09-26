<?php
date_default_timezone_set('Asia/Calcutta');
session_start();
//add code for cookie


include("../Database/dbConnect.php");
$userid = isset($_SESSION['username'])?$_SESSION['username']:"0";
 if($userid=="0") echo "<script>window.open('../login/', '_self')</script>";
$matchid = $_SESSION['matchid'];
$gid = substr($matchid,3,2);
$session = substr($matchid,7,1);
switch($gid)
{
	case 'G1': $groundname='MainGround'; break;
	case 'G2' : $groundname='Ground-II'; break;
	case 'G3' : $groundname='Ground-III'; break;
	case 'G4' : $groundname='Ground-IV@SRIIT,Hyd.'; break;
	default : $groundname='error';
}

switch($session)
{
	case 1 : $matchTime="8AM to 11AM"; break;
	case 2 : $matchTime="11AM to 2PM"; break;
	case 3 : $matchTime="2PM to 5PM"; break;
	 default : echo "<script>1window.open('../login/', '_self')</script>";
}
?>

<head>
<style>
fieldset{ display:inline; }
table{ border-collapse:collapse; border-color:white;}
.green{	background-color:green; color:white;}
.red{	background-color:green; color:yellow;}
td .green{color:yellow;}
#d1{text-align:right;}
*{line-height:25px;font-size:12pt;}
</style>
</head>

<body>

<?php
	include('header.php');
?>
<div >
<?php 
echo "<form name='test1' action='test0.php' method='POST'>";
echo "<center>";
echo "<table border=1 class='responsive'> <tr><td class='red'>Name of the Ground</td><td class='green'>$groundname</td></tr>";
echo "<tr><td class='red'>Date</td><td class='green'>",date('d-m-Y'), "</td></tr>";
echo "<tr><td class='red'>Match Time</td><td class='green'>",$matchTime , "</td></tr>";
$con = getConnection();
$today = date("Y-m-d");
$qry1 = mysqli_query($con, "select * from `matches_2018` where `matchid` ='$matchid'");

if(mysqli_affected_rows($con) > 0)
{
	$rows=0;
while($res1 = mysqli_fetch_array($qry1)){
	if ($res1['status']== "active"){
		$rows=1;
	echo "<tr><td class='red'>Match ID </td><td class='green'>$res1[0]</td><tr>";
	
	$matchid = $res1['matchid'];
	$_SESSION['groundid'] = $matchid;
	$team1id = $res1['team1id'];
	$team2id = $res1['team2id'];
	$_SESSION['team1id']=$team1id;
	$_SESSION['team2id']=$team2id;
	}
}
if($rows!=1) goto end;
$qry2 = mysqli_query($con, "select * from `teamid`");
while ($res2 = mysqli_fetch_array($qry2)){
	if($team1id == $res2['teamid'])
		$team1name = $res2['collegename'];
	if($team2id == $res2['teamid'])
		$team2name = $res2['collegename'];
}

echo "<tr><td class='red'>Team-1 Name </td> <td class='green'> $team1name </td></tr>";
echo "<tr><td class='red'>Team-2 Name </td> <td class='green'> $team2name </td></tr>";
echo "<tr><td class='red'>TOSS won by</td> <td class='green'>" ;
?>
<select name='toss_teamid' class='green'>
 <option value=0 selected>Select Team Name</option> 
 <option value='<?php echo $team1id; ?>' > <?php echo $team1name; ?> </option>
 <option value='<?php echo $team2id; ?>' > <?php echo $team2name; ?> </option>
</select>
<?php
 echo "<select name='tosstype' class='green'> <option value=0 selected>Select </option> ";
 echo "<option value='Batting'>Batting</option> <option value='Bowling'>Bowling</option></select></td></tr>";
?>
<tr> <td align='center' class='green'>overs</td><td><input type="number" name='overs'  value="20" class='green'></td></tr>
 
  <tr> <td colspan=2 align='center'><input type='submit' value='ok'> &nbsp;
  <input type='reset' value='reset'>
  </td></tr>
  </table> 
  </center>
 
</form>
</div>
<?php
goto end2;
}
else goto end;
end:
	echo "<tr><td colspan=2 style='text-align:center;' class='red'>Sorry!No Match is scheduled</td></tr></table>";
end2:
?>

</body>