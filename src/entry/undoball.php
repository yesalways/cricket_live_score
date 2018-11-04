<?php 
          date_default_timezone_set('Asia/Calcutta');
				session_start();
				include('getTeamNames.php');
                include("../Database/dbConnect.php");
                if(!isset($_SESSION['username']))
				{
					echo "<script>window.open('../login/', '_self')</script>";
				}
                $con = getConnection();
                $matchid=$_SESSION['matchid'];
                $inning=$_SESSION['inning'];
                $q=mysqli_query($con,"SELECT * from `$matchid` where `inning`='$inning' order by `thetime` desc limit 1 ");
                while($res=mysqli_fetch_array($q))
                {
                    $inning1=$res['inning'];
                    $batsmanid=$res['batsmanid'];
                    $bowlerid=$res['bowlerid'];
                    $total=$res['total'];
                    $overs=$res['overs'];
                    $balls=$res['balls'];
                    $score=$res['score'];
                    $extra=$res['extra'];
                    $extratype=$res['extratype'];
                    $outtype=$res['outtype'];
                    $fielderid=$res['fielderid'];
                }
            
                if($outtype==""&&$extratype=="fair")
                {
                    $q=mysqli_query($con,"UPDATE `batting` set `runs`=`runs`-$score,`balls`=`balls`-1,`n$score`=`n$score`-1 where `matchid`='$matchid' and `playerid`='$batsmanid' ");
                    $q = mysqli_query($con, "UPDATE `bowling` set `runs`=`runs`-$score,`balls`=`balls`-1 where `matchid`='$matchid' and `playerid`='$bowlerid' ");

                }
                else if($outtype!="")
                {
                    if($outtype=="Runout")
                    {
                        $q = mysqli_query($con, "UPDATE `batting` set `runs`=`runs`-$score,`balls`=`balls`-1,`n$score`=`n$score`-1,`out_type`='',`out_bowlerid`='',`out_fielderid`='' where `matchid`='$matchid' and `playerid`='$batsmanid' ");
                        $q = mysqli_query($con, "UPDATE `bowling` set `runs`=`runs`-$score,`balls`=`balls`-1 where `matchid`='$matchid' and `playerid`='$bowlerid' ");

                    }
                    else{
                        $q = mysqli_query($con, "UPDATE `batting` set `runs`=`runs`-$score,`balls`=`balls`-1,`n$score`=`n$score`-1,`out_type`='',`out_bowlerid`='',`out_fielderid`='' where `matchid`='$matchid' and `playerid`='$batsmanid' ");
                        $q = mysqli_query($con, "UPDATE `bowling` set `runs`=`runs`-$score,`balls`=`balls`-1,`wickets`=`wickets`-1 where `matchid`='$matchid' and `playerid`='$bowlerid' ");
                    }
                }
                else{
                    if($extratype=='Bye'||$extratype='Legbye'){
                      $q = mysqli_query($con, "UPDATE `batting` set `balls`=`balls`-1 where `matchid`='$matchid' and `playerid`='$batsmanid' ");
                    }
                    $q = mysqli_query($con, "UPDATE `bowling` set `runs`=`runs`-$score,`balls`=`balls`-1,`extras`=`extras`-$extra where `matchid`='$matchid' and `playerid`='$bowlerid' ");

                }

        $qu=mysqli_query($con,"DELETE from `$matchid`  where  `inning`='$inning' order by `thetime` desc limit 1 ");
                      //echo $qu;
        echo "<script>window.open('test1.php', '_self')</script>";
 ?>