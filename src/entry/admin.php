<html>
<head>
<script type="text/javascript" src="../../lib/jquery/jquery.min.js"></script>
<script type="text/javascript">

  function loaddata(){
        var name=document.getElementById( "username" ).value

        if(name)
        {
        $.ajax({
        type: 'post',
        url: 'loaddata.php',
        data: {
        username:name,
        },
        success: function (response) {
        $( '#display_info' ).html(response);
        }
        });
        }
            
        else
        {
        $( '#display_info' ).html("Please Enter Some Words");
        }
 }

</script>

</head>
<body>
        <?php
        date_default_timezone_set('Asia/Calcutta');
        session_start();

         include('header.php');

		echo "<h1>ADMIN</h1>";
        echo "<div id='row'>";
        echo "<div>Scorers</div>";
          
         include('../Database/dbConnect.php');
         $userid = isset($_SESSION['username']) ? $_SESSION['username'] : "0";
            if ($userid == "0") {
                echo "<script>window.open('../login/index.php', '_self')</script>";
            }

          $con=getConnection();
         
          echo "<table border=1 style='display:inline-block' title='Scorers'>";
          echo "<tr><th>Userid</th><th>Password</th><th>Groundid</th><th>Status</th><th>delete</th>";
          $qry1=mysqli_query($con,"SELECT * from login");
          $i=0;
          while($res=mysqli_fetch_array($qry1))
          {
              echo "<tr><td>$res[0]</td><td>$res[1]</td><td>$res[2]</td><td>$res[3]</td> </tr>";
          }
          echo "</table><br>";

          echo "<div id='row'>";
          echo "<form name='addscorer' method='post' action='addscorer.php'>";
          echo "<tr><td><input type='text' name='uname' placeholder='username' id='uname'/></td>";
          echo "<td><input type='text' placeholder='password' name='pwd'/></td>";
          echo "<td><select name='ground'> <option value='G1'>ground1</option> <option value='G2'>ground2</option> <option value='G3'>ground3</option> <option value='G4'>ground4</option></select></td>";
           echo "<td> <input type='submit' value='add'/></td></tr></form>";

           echo "<form name='deletescorer' method='post' action='deletescorer.php'>";
           echo "<tr><td><input type='text' name='uname' placeholder='username' id='uname'/></td>";
          echo "<td> <input type='submit' value='delete'/></td></tr></form>";

           echo "</div>";
         
          
          ?>
        </div>
        <div id="row">
          <div>Active Matches</div>
         <?php 
           $qry=mysqli_query($con,"SELECT * from `matches_2018` where `status` like 'active' ");
           echo "<table border=1 style='display:inline-block' title='Active Matches'>";
            echo "<tr><th>Matchid</th><th>teamA</th><th>TeamB</th><th>ScheduledOn</th>";
            echo "<th>status</th><th>Toss</th><th>Choose</th><th>Overs</th><th>Inning1</th><th>Inning2</th></tr>";

            while($res=mysqli_fetch_array($qry))
            {
                echo "<tr>";
                for($i=0;$i<10;$i++)
                {
                    echo "<td>$res[$i]</td>";
                }
                echo "</tr>";
            }
            echo "</table>";

            echo "<form name='activatematch' method='post' action='activatematch.php'>";
            echo "<tr><td><input type='text' name='matchid' placeholder='matchid' id='matchid'/></td>";
            echo "<td> <input type='submit' value='activate'/></td></tr></form>";

          ?>
        </div>
<input type="text" name="username" id="username" onkeyup="loaddata();">
<div id="display_info" >
hello!
</div>
	 
</body>
<?php //header("Refresh:5; url=admin.php"); ?>
</html>