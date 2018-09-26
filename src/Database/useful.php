<?php
function createtable()
{
    $matchid=$_SESSION['matchid'];
    $con=getConnection();
    $qry=mysqli_query($con,"CREATE TABLE IF NOT EXISTS `$matchid` (
        `sno` int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `inning` char(1) NOT NULL,
        `batsmanid` varchar(10) NOT NULL,
         `bowlerid` varchar(10) NOT NULL,
         `total` int(3) NOT NULL,
        `overs` int(2) NOT NULL,
         `balls` int(2) NOT NULL,
         `score` int(3) NOT NULL,
        `extra` int(2) DEFAULT NULL,
        `extratype` varchar(15) DEFAULT NULL,
        `outtype` varchar(10) DEFAULT NULL,
        `fielderid` varchar(10) DEFAULT NULL,
        `thetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
    )ENGINE=InnoDB DEFAULT CHARSET=latin1");
  
   
      echo $qry;
    if ($qry) 
    {
        echo "success..";
        $qry2=mysqli_query($con,"INSERT into  $matchid(`inning`,`batsmanid`,`bowlerid`,`total`,`overs`,`balls`,`score`) values ('1','.','.','0','0','0','0') ");
        //dummy record
    }
    else 
    {
        echo "unsuccess..";
        echo "this match is already started";
    }
}


?>