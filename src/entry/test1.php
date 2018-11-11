
		<?php
				// source .. from srtrophy/entry/index
				date_default_timezone_set('Asia/Calcutta');
				session_start();
				include('getTeamNames.php');
				include("../Database/dbConnect.php");
				$con = getConnection();
				
				$matchid=$_SESSION['matchid'];
				if(!isset($_SESSION['username']))
				{
					echo "<script>window.open('../login/', '_self')</script>";
				}
				else
				{
					$qry1=mysqli_query($con,"select `teamA`,`teamB` from `match_scores` where `match_id`='$matchid' ");
					$fbat=null; $fbowl=null;
					$team1_details[0]='';
					while($res=mysqli_fetch_array($qry1))
					{
						$fbat=$res['teamA'];
						$fbowl=$res['teamB'];
					}
					//echo $bat," ",$bowl;
					$qry2=mysqli_query($con,"select `overs`,`inning1start`,`inning1end`,`inning2start`,`inning2end` from `matches_2018` where `matchid`='$matchid' ");
					while($res=mysqli_fetch_array($qry2))
					{
						$_SESSION['overs']=$res['overs'];
						$i1s=$res['inning1start'];
						$i1e=$res['inning1end'];
						$i2s=$res['inning2start'];
						$i2e=$res['inning2end'];
					}
					if($i1e==NULL&&$i2s==NULL)
					{
						$_SESSION['inning']=1;
						$team1_details = getTeamNames($fbat, $matchid);
						$team2_details = getBowlersNames($fbowl, $matchid);
						$bowlerCount = $team2_details[0];
					}
					else if($i1e!=NULL&&$i2e==NULL)
					{
						$_SESSION['inning']=2;
						$team1_details = getTeamNames($fbowl, $matchid);
						$team2_details = getBowlersNames($fbat, $matchid);
						$bowlerCount = $team2_details[0];
					}
					else
					{
							echo "match finished";
							echo "<script>window.open('logout.php','_self')</script>";
					}
					
				
				}
				// $gid = $_SESSION['matchid'];

			include('header.php');
		?>

<html>
<head>

  <!-- Favicons -->
  <link href="../img/fav-icon.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="../../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="../../lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../../lib/animate/animate.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="../../lib/css/style.css" rel="stylesheet">

		<style>
				fieldset{
				display:inline;
				}
				table{
					border-collapse:collapse;
				}
				.container{
					margin-left:0%;
				}
				#d1{
					text-align:right;
				}
				*{line-height:22px;font-size:11pt;}
				select:hover, input:hover{}
				th{height:40px;min-width:55px;}
				tr:nth-child(odd) {background: 	#F0FFF0}
				tr:nth-child(even) {background: #FAFAD2}
				#center{text-align:center;font-size:85%}
				select{font-size:10px;width:80px;}
		</style>
	<script src="../../lib/jquery/jquery.min.js"></script>
	
	<script src="../../lib/js/scoring.js"></script>
	
</head>

<body >
 <center>

	<div class='container'>
		<form name='test1' action='test2.php' method='POST'>
			<table border='1' style='margin-top:2%;' class='tablep-responsive'>
				<tr> <th id='center' colspan='5'> Inning Type : 
						<?php
						   $inning=$_SESSION['inning'];
						    echo $inning;
						    $overqry=mysqli_query($con,"SELECT * from `match_scores`  where  `match_id`='$matchid' ");
							while($row=mysqli_fetch_array($overqry))
							{
								if($inning==1)
								{
								  $total=$row['scoreA'];
								  $wickets=$row['wicketsA'];
								  $balls=$row['ballsA'];
								}
								if($inning==2)
								{
								    $total = $row['scoreB'];
									$wickets = $row['wicketsB'];
									$balls = $row['ballsB'];			
								}
							}
							
							echo " score : ",$total,"/",$wickets,"  over : ",(int)($balls/6)+0.1*(int)($balls%6)," (",$_SESSION['overs'],")";
						?></th>
				 </tr>
				<tr> <th id='center'> Current Batsman -</th> <td> <select name='batsman' id='select1'> 
					<?php for($x=0; $x<15; $x++) { 
					?>
					<option value='<?php echo $team1_details[$x]; ?>'> <?php echo $team1_details[$x]; ?> </option>
					<?php } ?>
					</select> </td>
					<th id='center'> Current Bowler - </th> <td>  <select name='bowler' id='select1'> 
					<?php for($x=1; $x<=$bowlerCount; $x++) { 
					?>
					<option value='<?php echo $team2_details[$x]; ?>'> <?php echo $team2_details[$x]; ?> </option>
					<?php } ?>
					</select>
					 </td> 
			  </tr>

					<tr id='balltype'> 
							<th id='extra'> <input type='radio' name='balltype' onchange='extras();'>Extra </th>
							<th id='wicket'> <input type='radio' name='balltype'onchange='wickets();'>wicket </th>
							<th id='run'>    <input type='radio' name='balltype' onchange='runs();'>runs</th>
					</tr>

					<tr align="center"> 
					
						<td id='extras'> 
						    <input type='radio' name='extras' id='fair'  value='fair' checked>Fair<br>
							<input type='radio' name='extras' id='legbye' value='Legbye' > LegBye <br>
							<input type='radio' name='extras' id='bye' value='Bye' >  Bye <br>
							<input type='radio' name='extras' id='wide' value='Wide'  > Wide <br>
							<input type='radio' name='extras' id='noball' value='Noball'> Noball
						</td> 
				 
					
							<td id='runs'>
								<input type='radio' name='runs' id='runs0' value='0' checked>0 &nbsp; 
								<input type='radio' name='runs' id='runs1' value='1'>1 <br> 
								<input type='radio' name='runs' id='runs2' value='2'>2 &nbsp;
								<input type='radio' name='runs' id='runs3' value='3'>3 <br>
								<input type='radio' name='runs' id='runs4' value='4'>4 &nbsp; 
								<input type='radio' name='runs' id='runs6' value='6'>6
							</td>		
						
					  
						<td id='wickets'> 
						    <input type='radio' name='wickets' id="notout" value='Notout' checked>Notout<br>
							<input type='radio' name='wickets' id="bowled" value='Bowled' >Bowled<br>
							<input type='radio' name='wickets' id="runout" value='Runout' >Runout<br>
							<input type='radio' name='wickets' id="caught" value='Caught' >Catch
								<select name='fielder_catch' id='selectcatch'> 
										<?php for($x=1; $x<=15; $x++) { 
										?>
										<option value='<?php echo $team1_details[$x]; ?>'> <?php echo $team1_details[$x]; ?> </option>
										<?php } ?>
									</select> <br> 
							
							
							<input type='radio' name='wickets' id="lbw" value='Lbw'>LBW<br>
							<input type='radio' name='wickets' id="stumped" value='Stumped'>Stumped
						</td>
					</tr>
					
					<tr>
					<td colspan='3' style='text-align:center'>
					<input type='submit' value='ok'> &nbsp;
					<input type='reset' value='reset'>
					
					</td>
					
					</tr>
			</table>
					
		</form>
	
	<td><button onclick="window.open('undoball.php','_self')">undo last ball</button></td>
	</div>
	<div><?php echo ExactBrowserName(); ?></div>
 </center>
</body>
</html>

