<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>SR Champions Trophy</title>
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<meta content="SR Engineering College, SREC Warangal, Cricket SR Engineering College, SR Champions Trophy" name="keywords">
		<meta content="SR Engineering College (SREC) established in the year 2002 is sponsored by Sri Rajeshwara Educational Society which has four decades of rich experience in the field of Education. It is located on Warangal-Karimnagar highway at about 15 KM away from Warangal City. SR Group runs 3 Engineering Colleges, and scores of Junior Colleges and Schools spreading over Telangana and Andhra Pradesh." name="description">

		<!-- Favicons -->
		<link href="../resources/img/fav-icon.png" rel="icon">

		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

		<!-- Bootstrap CSS File -->
		<link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- Libraries CSS Files -->
		<link href="../lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../lib/animate/animate.min.css" rel="stylesheet">

		<!-- Main Stylesheet File -->
		<link href="../lib/css/style.css" rel="stylesheet">
		<style>
			.content, empty{
			float:left;
			}
			.content>p{min-width:100px;}
			table{border-collapse:collapse;}
			th,td{min-width:20px;}
			th{background-color:#a5500fff;border-color:white;color:white;}
			td{even-row(color:red;)}
		</style>
	 </head>

	<?php
			session_start();
			date_default_timezone_set('Asia/Calcutta');
			$groundid = $_GET['id'];
			include("Database/dbConnect.php");
			$con = getConnection();	 
				function get_collegename($tid,$con)
				{
					$qry2 = mysqli_query($con, "select * from `teamid` where `teamid` like '$tid' ");
					while($res2=mysqli_fetch_array($qry2))
							return $res2['collegename'].', '.$res2['district'];
				}
			function get_clgcode($tid,$con)
				{
					$qry3 = mysqli_query($con, "select * from `teamid` where `teamid` like '$tid' ");
					while($res3=mysqli_fetch_array($qry3))
							return $res3['teamid']; //college code
				}
					include('groundNames.php');
					$groundNames=groundNames();
					$qry1 = mysqli_query($con, "select * from `matches_2018` where `matchid` like '%G$groundid%' and `status`='active' ");
					if(mysqli_affected_rows($con) == 0)
					{
						echo $groundid, ' ', mysqli_affected_rows($con);
						echo "<p>match was not started..</p>";
					}
					else
					{		
						echo "<small>";
						$team1name=$team2name="";
						$firstBat=$secondBat="";
						while($res = mysqli_fetch_array($qry1))
						{
							$matchid =$res['matchid'];
							$team1id =$res['team1id'];
							$team2id =$res['team2id'];
							$team1clgname = get_collegename($res['team1id'],$con);
							$team2clgname = get_collegename($res['team2id'],$con);
							$team1clgcode= get_clgcode($res['team1id'],$con);
							$team2clgcode = get_clgcode($res['team2id'],$con);
							if($res['toss_type']=='Batting') $firstBat = $res['toss_teamid'];
							else if($res['toss_type']=='Bowling'){
								$temp = $res['toss_teamid'];			
								$firstBat = ($team1id==$temp)?$team2id:$team1id;
							}
							if($firstBat==$team1id) $secondBat=$team2id;
							else $secondBat=$team1id;
					   }
							$vs1 = $team1clgcode.' Vs '. $team2clgcode;
							$vs2 = $team1clgname.' <br><small><u>Vs</u></small><br>'. $team2clgname;
							$Vs2 = $team1clgname.' Vs '. $team2clgname;
							
							switch($groundid){
								case 1: header("Refresh:5; url=groundscore.php?id=1"); break;
								case 2: header("Refresh:5; url=groundscore.php?id=2"); break;
								case 3: header("Refresh:5; url=groundscore.php?id=3"); break;
								case 4: header("Refresh:5; url=groundscore.php?id=4"); break;
								}
								echo "<div>";
						echo "<center><b>Ground-$groundid ($groundNames[$groundid])</div>";
						include('matchSchedule.php');
					}
	 ?>


	<div class='container'>
   <div id="main">
    <section id="services">
      <div class="container wow fadeIn" style='margin-bottom:0pt'>
        <div class="section-header" style='margin-bottom:0pt'>
          <h3 class="section-title">Match Summary</h3>
          <div class="section-description" style='font-size:20pt; margin-bottom: -10pt;'><?php echo $vs2; ?>
					</div>
          </div>
					<p style='font-size:14pt; margin-bottom:0pt; color:green'> 
						<?php echo "<u>",($team1id==$res[5]?$team1clgname:$team2clgname),"</u> won the TOSS and choosen ", $res[6], "<br> Match schedule is ", matchSchedule(substr($matchid,7,1)); ?> </p>
        	<div class="row" style='margin-top:0pt'>
         	 <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
		 				 <center>1<sup>st</sup>Innings</center>
           	 <div class="box">
				<?php
				$matchid = strtolower($matchid); //echo $matchid;
				$total=$overs=$balls=0;
				$overqry = mysqli_query($con, "select total,overs,balls  from `$matchid`  where  `inning`=1 order by `thetime` desc limit 1  ");
				if($overqry===false){}
				else
				{
					while ($row = mysqli_fetch_array($overqry)) {
					$total = $row['total'];
					$overs = $row['overs'];
					$balls = $row['balls'];
					}
				}
				echo "<tr>$team1id : $total overs : $overs.$balls</tr>";
				?>
            	 <p  style='margin:0px 0 0 0'>
			  				<?php
								 $matchid = strtolower($matchid); //echo $matchid;
										echo "<table border=1 style='display:inline-block' title='$Vs2'>";
											echo "<tr><th rowspan=2>Batsman</th><th>0s</th><th>1s</th><th>2s</th><th>3s</th><th>4s</th><th>6s</th><th rowspan=2>Runs</th><th rowspan=2>Balls</th><th rowspan=2>Strike<br>Rate</th></tr>";
											echo "<tr>";
									
											//for($i=1;$i<=15;$i++)
											//{  
												$qry3 = mysqli_query($con, "SELECT `playerid`,`n0`,`n1`,`n2`,`n3`,`n4`,`n6`,`balls` from `batting` where `matchid`='$matchid' and `teamid`='$firstBat' ");
												if($qry3===false)
												{  echo "<tr><td>NA</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0.0</td></tr>";
												}
											  else{  
												  while ($res = mysqli_fetch_array($qry3)) {
													  $runs=$res[2]+$res[3]*2+$res[4]*3+$res[5]*4+$res[6]*6;
													  $srate=0;
													  if($res[7]!=0)
													  $srate = (($runs + 0.0) / $res[7])*100;

												  	echo "<tr><td>$res[0]</td><td>$res[1]</td><td>$res[2]</td><td>$res[3]</td><td>$res[4]</td><td>$res[5]</td><td>$res[6]</td><td>$runs</td><td>$res[7]</td><td>$srate</td></tr>";
												   }
												  
											  }
											//}
									
											echo "<tr style='text-align:center;background-color:Red; color:white'><td>......</td><td colspan=8></td></tr></table>";		 
										//	} //affected rows
										 echo "<br/><br/>";
										echo "<table border=1 style='display:inline-block' title='Bowling'>";
										echo "<tr><th rowspan=2>Bowler</th><th>balls</th><th>runs</th><th>wickets</th><th>extras</th><th>economy</th></tr>";
										echo "<tr>";
										$qry3 = mysqli_query($con, "SELECT `playerid`,`balls`,`runs`,`wickets`,`extras` from `bowling` where `matchid`='$matchid' and `teamid`='$secondBat' ");
										if ($qry3 === false) {echo "<tr><td>NA</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0.0</td></tr>";
										} else {
											while ($res = mysqli_fetch_array($qry3)) {
											
												$economy = 0;
												if ($res[1] != 0) {
													$economy = (($res[2]+0.0) / $res[1]) * 6;
												}

												echo "<tr><td>$res[0]</td><td>$res[1]</td><td>$res[2]</td><td>$res[3]</td><td>$res[4]</td><td>$economy</td></tr>";
											}

										}
										

										echo "<tr style='text-align:center;background-color:Red; color:white'><td>......</td><td colspan=8></td></tr></table>";

									?>
			  
  			  		 </p>
             </div>
					  </div> <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
		 				 <center>2<sup>nd</sup>Innings</center>
           	 <div class="box">
				<?php
					$matchid = strtolower($matchid); //echo $matchid;
					$total2=$overs2=$balls2=0;
					$overqry = mysqli_query($con, "select total,overs,balls  from `$matchid`  where  `inning`=2 order by `thetime` desc limit 1  ");
					if($overqry===false){}
					else
					{
						while ($row = mysqli_fetch_array($overqry)) {
						$total2 = $row['total'];
						$overs2 = $row['overs'];
						$balls2 = $row['balls'];
						}
					}
					echo "<tr>$team2id : $total2 overs : $overs2.$balls2</tr>";
					?>
            	 <p id="ground1" style='margin:0px 0 0 0'>
			  				<?php
								 $matchid = strtolower($matchid); //echo $matchid;
                  // echo $firstBat;
											echo "<table border=1 style='display:inline-block' title='$Vs2'>";
											echo "<tr><th rowspan=2>Batsman</th><th>0s</th><th>1s</th><th>2s</th><th>3s</th><th>4s</th><th>6s</th><th rowspan=2>Runs</th><th rowspan=2>Balls</th><th rowspan=2>Strike<br>Rate</th></tr>";
											echo "<tr>";
										 
											//for($i=1;$i<=15;$i++)
											//{  
												$qry3 = mysqli_query($con, "SELECT `playerid`,`n0`,`n1`,`n2`,`n3`,`n4`,`n6`,`balls` from `batting` where `matchid`='$matchid' and `teamid`='$secondBat' ");
												if($qry3===false)
												{  echo "<tr><td colspan=10>NA</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0.0</td></tr>";
												}
											  else{  
												  while ($res = mysqli_fetch_array($qry3)) {
													  $runs = $res[2] + $res[3] * 2 + $res[4] * 3 + $res[5] * 4 + $res[6] * 6;
														$srate = 0;
														if ($res[7] != 0) {
															$srate = (($runs + 0.0) / $res[7]) * 100;
														}

												  	echo "<tr><td>$res[0]</td><td>$res[1]</td><td>$res[2]</td><td>$res[3]</td><td>$res[4]</td><td>$res[5]</td><td>$res[6]</td><td>$runs</td><td>$res[7]</td><td>$srate</td></tr>";
												   }
												  
											  }
											//}
									
											echo "<tr style='text-align:center;background-color:Red; color:white'><td>......</td><td colspan=8></td></tr></table>";		 
										//	} //affected rows
                                       echo "<br/><br/>";
										echo "<table border=1 style='display:inline-block' title='bowling'>";
										echo "<tr><th rowspan=2>Bowler</th><th>balls</th><th>runs</th><th>wickets</th><th>extras</th><th>economy</th></tr>";
										echo "<tr>";
										$qry3 = mysqli_query($con, "SELECT `playerid`,`balls`,`runs`,`wickets`,`extras` from `bowling` where `matchid`='$matchid' and `teamid`='$firstBat' ");
										$overs=0;
										if ($qry3 === false) {echo "<tr><td>NA</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0.0</td></tr>";
										} else {
											while ($res = mysqli_fetch_array($qry3)) {

												$economy = 0;
												if ($res[1] != 0) {
													$economy = (($res[2] + 0.0) / $res[1]) * 6;
													//$overs=($res[1]+0.0)/6+$res[1]%6;
												}

												echo "<tr><td>$res[0]</td><td>$res[1]</td><td>$res[2]</td><td>$res[3]</td><td>$res[4]</td><td>$economy</td></tr>";
											}

										}

										echo "<tr style='text-align:center;background-color:Red; color:white'><td>......</td><td colspan=8></td></tr></table>";

									?>
			  
  			  		 </p>
             </div>
			 </div>
		 </section>
    </div>
   </div>
 </html>