<?php
include("../Database/dbConnect.php");

// loaddata.php

if (isset($_POST['username'])) {

    $name = $_POST['username'];
   $con=getConnection();
    $selectdata = " SELECT * FROM `login` WHERE `user_id` LIKE '%$name%' ";

    $query = mysqli_query($con, $selectdata);
    $cnt = 1;
    while ($row = mysqli_fetch_array($query)) {
        $cnt = 0;
        echo "<p>" . $row['user_id'] . $row['pwd'] . "</p>";
    }
    if ($cnt) {
        echo "<p>No records were found";
    }

}
