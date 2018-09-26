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
        $qu=mysqli_query($con,"DELETE from `$matchid`  where  `inning`='$inning' order by `thetime` desc limit 1 ");
                      //echo $qu;
        echo "<script>window.open('test1.php', '_self')</script>";
 ?>