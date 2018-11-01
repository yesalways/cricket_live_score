<?php
include("../Database/dbConnect.php");

// loaddata.php
$return_arr = array();
if (isset($_POST['match_id'])) {
    
    $matchid = $_POST['match_id'];
   $con=getConnection();
    $selectdata = " SELECT * FROM `matches_2018` WHERE `matchid` LIKE '%$matchid%' ";

    $query = mysqli_query($con, $selectdata);
    $cnt = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        $cnt = 0;
        $return_arr[]=array("matchid"=>$row[0],"teamA"=>$row[1],"teamB"=>$row[2],"scheduledon"=>$row[3],"status"=>$row[4]);
    }
    echo json_encode($return_arr);

    if ($cnt) {
        echo "<p>No records were found";
    }
   // mysqli_close($con);
}
