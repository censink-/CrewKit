<?php
require "db/connect.php";
$getlatestkill = mysqli_query($db, "SELECT WIN_USER FROM kill_log order by DATE_TIME desc LIMIT 1");
$latestkill = mysqli_fetch_array($getlatestkill);
?>
<div style="width:100%;height:40px;background-color:rgba(255,255,255,0.5);bottom:0px;left:0px;position:fixed;border-top:3px solid rgba(255,255,255,0.5);text-align:center;vertical-align:middle;box-shadow:0 0 5px 0px gray;"><h5>Latest Kill By <a href="player?name=<?php echo $latestkill[0]; ?>"><?php echo $latestkill[0]; ?></a>!</h5></div>
