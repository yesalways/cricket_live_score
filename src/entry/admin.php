<html>
 <head>

  <script type="text/javascript" src="../../lib/jquery/jquery.min.js"></script>
  <script>
  function loaddata(){
        var Ajaxmatchid=document.getElementById( "ajaxmatchid" ).value

        if(Ajaxmatchid)
        {
        $.ajax({
        url: 'loaddata.php',
        data: {  match_id:matchid },
        success: function (response) {
            $('#display_info').html('');
            var results=JSON.parse(response);
            $.each(results,function(key,value){
                 $('#display_info').append(value.matchid+'<br>');
            });
            if(results.length==0){
                $('#display_info').html('no results found');
            }
            /*var len=response.length;
            for(var i=0;i<len;i++){
                var matchid=response[i].matchid;
                var teamA=response[i].teamA;
                var teamB=response[i].teamB;
                var scheduledon=response[i].scheduledon;
                var status=response[i].status;
                var result="<tr>"+
                           "<td align='center'>"+matchid+"</td>"+
                           "<td align='center'>"+teamA+"</td>"+
                           "<td align='center'>"+teamB+"</td>"+
                           "<td align='center'>"+scheduledon+"</td>"+
                            "<td align='center'>"+status+"</td>"+
                           "</tr>";
             $('#display_info').append(result);
            }*/
        }
        });
        }
            
        else
        {
        $('#display_info').html("Please Enter Some Words");
        }
   }

 </script>

 </head>
 <body>
 <div id="container">
        <?php
        date_default_timezone_set('Asia/Calcutta');
        session_start();
         include('../Database/dbConnect.php');
         $userid = isset($_SESSION['username']) ? $_SESSION['username'] : "0";
            if ($userid == "0") {
                echo "<script>window.open('../login/index.php', '_self')</script>";
            }

          $con=getConnection();
           
            if(isset($_POST['AddScorer']))
            {
                $uname = $_POST['uname'];
                $pwd = $_POST['pwd'];
                $ground = $_POST['ground'];
                //echo $uname,$pwd,$ground;
                $qry = mysqli_query($con, "INSERT into `login` values('$uname','$pwd','$ground','0')");
                if ($qry != 0) {
                    echo "<script>window.open('admin.php', '_self');window.alert('saved successfully');</script>";
                } else {
                    echo "<script>window.open('admin.php', '_self');window.alert('not saved');</script>";
                }

            }
            if(isset($_POST['DeleteScorer']))
            {
                $uname = $_POST['uname'];
                //echo $uname,$pwd,$ground;
                //echo $uname;
                $qry = mysqli_query($con, "DELETE from `login` where `user_id`='$uname' ");
                if ($qry != 0) {
                    echo "<script>window.open('admin.php', '_self');window.alert('deleted successfully');</script>";
                } else {
                    echo "<script>window.open('admin.php', '_self');window.alert('not deleted');</script>";
                }

            }
            if(isset($_POST['ActivateMatch']))
            {
                    $matchid = $_POST['matchid'];
                //echo $uname,$pwd,$ground;
                //echo $uname;
                $qry = mysqli_query($con, "UPDATE `matches_2018` set `status`='active' where `matchid`='$matchid' ");
                if ($qry != 0) {
                    echo "<script>window.open('admin.php', '_self');window.alert('match activated');</script>";
                } else {
                    echo "<script>window.open('admin.php', '_self');window.alert('match not activated');</script>";
                }
           }
        include 'header.php';

            echo "<h1>ADMIN</h1>";
            echo "<div id='row'>";
            echo "<div>Scorers</div>";

          echo "<div><table border=1 style='display:inline-block' title='Scorers'>";
          echo "<tr><th>Userid</th><th>Password</th><th>Groundid</th><th>Status</th><th>delete</th>";
          $qry1=mysqli_query($con,"SELECT * from login");
          $i=0;
          while($res=mysqli_fetch_array($qry1))
          {
              echo "<tr><td>$res[0]</td><td>$res[1]</td><td>$res[2]</td><td>$res[3]</td> </tr>";
          }
          echo "</table>";

          echo "<div id='row'>";
          echo "<form name='addscorer' method='post' action=''>";
          echo "<tr><td><input type='text' name='uname' placeholder='username' id='uname'/></td>";
          echo "<td><input type='text' placeholder='password' name='pwd'/></td>";
          echo "<td><select name='ground'> <option value='G1'>ground1</option> <option value='G2'>ground2</option> <option value='G3'>ground3</option> <option value='G4'>ground4</option></select></td>";
           echo "<td> <input type='submit' name='AddScorer' value='add'/></td></tr></form>";

           echo "<form name='deletescorer' method='post' action=''>";
           echo "<tr><td><input type='text' name='uname' placeholder='username' id='uname'/></td>";
          echo "<td> <input type='submit' name='DeleteScorer' value='delete'/></td></tr></form>";

           echo "</div></div>";
          
          ?>
          <div>Active Matches</div>
          <div>
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

            echo "<form name='activatematch' method='post' action=''>";
            echo "<tr><td><input type='text' name='matchid' placeholder='matchid' id='matchid'/></td>";
            echo "<td> <input type='submit' name='ActivateMatch' value='activate'/></td></tr></form>";

          ?>
        </div>
        </div>
    <input type="text" name="ajaxmatchid" id="ajaxmatchid" onkeyup="loaddata();">Search
    
    <table id="display_info" border="1">
     hello
     <tr>
       <th width="10%">Matchid</th>
       <th width="10%">TeamA</th>
       <th width="20%">TeamB</th>
       <th width="20%">ScheduledOn</th>
       <th width="10%">Status</th> 
     <tr>
    </table>
    </div>   
 </body>
 <?php //header("Refresh:5; url=admin.php"); ?>
 </html>