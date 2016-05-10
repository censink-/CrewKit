<?php
	$nav = file_get_contents('header.php');
	$nav = str_replace('<li><a href="player"', '<li class="active"><a href="player"', $nav);
	$nav = str_replace('</head>', '<style>td {font-size: 13px;} .list-group-item .pull-right {margin-top:2px;}</style></head>', $nav);
	echo $nav;
?>
	<div class="container text-center">
		<?php
			require "db/connect.php";

			if (isset($_POST['inputName'])) {
				echo "<meta http-equiv='refresh' content='0;URL=player?name=" . $_POST['inputName'] . "'>";
			}
			if (!isset($_GET['name']) || $_GET['name'] == "") {
		?>
		<h1>Invalid username! <small>Enter one to continue</small></h1>
		<hr>
		<form action="player.php" method="post">
			<input required type="text" class="form-control" style="width:200px;display:inline;" name="inputName"> <button class="btn btn-success" style="margin-top:-3px;" type="submit">Go!</button>
		</form>
		<?php
			} else {

				$username = $_GET['name'];
				$getname = mysqli_query($db, "SELECT * FROM player WHERE USERNAME='$username' LIMIT 1");
				$pageview = mysqli_query($db, "UPDATE player SET PAGEVIEWS = PAGEVIEWS + 1 WHERE USERNAME='$username'");
				$name = mysqli_fetch_array($getname);
				if ($name['USERNAME'] != $username) {
					die("<meta http-equiv='refresh' content='0;URL=player?name=" . $name['USERNAME'] . "'>");
				};
				echo "<meta http-equiv=\"refresh\" content=\"30;URL=player?name=" . $username . "\">";
				echo '<h1>' . $username . '\'s stats!</h1>';

				$getstats = mysqli_query($db, "SELECT * FROM player WHERE USERNAME='$username'");
				$stats = mysqli_fetch_array($getstats);

				$getenemykills = mysqli_query($db, "SELECT `LOSE_USER`, COUNT(`LOSE_USER`) AS `value_occurrence` FROM `kill_log` WHERE WIN_USER = '$username' GROUP BY `LOSE_USER` ORDER BY `value_occurrence` DESC LIMIT 1");
				$enemykills = mysqli_fetch_array($getenemykills);

				$getenemydeaths = mysqli_query($db, "SELECT `WIN_USER`, COUNT(`WIN_USER`) AS `value_occurrence` FROM `kill_log` WHERE LOSE_USER = '$username' GROUP BY `WIN_USER` ORDER BY `value_occurrence` DESC LIMIT 1");
				$enemydeaths = mysqli_fetch_array($getenemydeaths);

				$playtime = $stats['PLAYTIME'];
				$playhours = round($playtime / 3600);
				if ($playhours >= 24) {
					$playdaysstring = floor($playhours / 24) . " day<br>";
					$playdays = floor($playhours / 24) . "d ";
					$playhours = $playhours - 24;
					if ($playhours >= 48) {
						$playdaysstring = floor($playdays / 24) . " days<br>";
						$playdays = floor($playhours / 24) . "d ";
						$playhours = $playhours - ($playdays * 24);
					}
				} else {
					$playdaysstring = "";
					$playdays = "";
				}
				$playhrr = $playtime % 3600;
				$playminutes = round($playhrr / 60);
				$playminr = $playhrr % 60;
				$playseconds = round($playminr / 60);
				if ($playhours == 1) {
					$playhoursstring = "1 hour<br>";
					$playhours = "1h ";
				} else if ($playhours == 0) {
					$playhoursstring = "";
					$playhours = "";
				} else {
					$playhoursstring = $playhours . " hours<br>";
					$playhours = $playhours . "h ";
				}
				if ($playminutes == 1) {
					$playminutesstring = "1 minute<br>";
					$playminutes = $playminutes . "m";
				} else if ($playminutes == 0) {
					$playminutesstring = "";
					$playminutes = "";
				} else {
					$playminutesstring = $playminutes . " minutes<br>";
					$playminutes = $playminutes . "m ";
				}
				if ($playseconds == 1) {
					$playsecondsstring = "1 second";
					$playseconds = "1s";
				} else if ($playseconds == 0) {
					$playsecondsstring = "";
					$playseconds = "";
				} else {
					$playsecondsstring = $playseconds . " seconds";
					$playseconds = $playseconds . "s";
				}
				$playstring = $playdays . $playhours . $playminutes . $playseconds;
				$fullplaystring = $playdaysstring . $playhoursstring . $playminutesstring . $playsecondsstring;

				if (!$fullplaystring) {
					$fullplaystring = "Nothing D:";
				}

				if ($stats['DEATHS'] != 0) {
					if ($stats['KILLS'] == 0) {
						$kd = round(1 / $stats['DEATHS'],2);
					} else {
						$kd = round($stats['KILLS'] / $stats['DEATHS'],2);
					}
				} else {
					$kd = $stats['KILLS'];
				}
		?>
		
		<hr>
		<div class="col-sm-3">
			<div class="thumbnail"><img src="https://minotar.net/helm/<?php echo $username; ?>/245.png"><div class="caption"><h3><?php echo $username; ?></h3></div></div>
			<br>
			<ul class="list-group text-left">
				<li class="list-group-item"><b>ELO Rating:</b> <span class=<?php if($stats['ELO'] >= 1000) { if($stats['ELO'] == 1000) { echo "\"label label-warning pull-right\""; } else { echo "\"label label-success pull-right\""; } } else { echo "\"label label-danger pull-right\""; } ?>><?php echo $stats['ELO']; ?></span></li>
				<li class="list-group-item"><b>Kills:</b> <span class="label label-success pull-right"><?php echo $stats['KILLS']; ?></span></li>
				<li class="list-group-item"><b>Deaths:</b> <span class="label label-danger pull-right"><?php echo $stats['DEATHS']; ?></span></li>
				<li class="list-group-item"><b>K/D Ratio:</b> <span class=<?php if($kd >= 1) { if($kd == 1) { echo "\"label label-warning pull-right\">" . $kd; } else { echo "\"label label-success pull-right\">" . $kd; } } else { echo "\"label label-danger pull-right\">" . $kd; } ?></span></li>
				<li class="list-group-item"><? if($stats['STREAK'] > 0) { echo "<b class=\"text-success\">Current killstreak:</b> <span class=\"label label-success pull-right\">"; } else { echo "<b class=\"text-danger\">Current deathstreak:</b> <span class=\"label label-danger pull-right\">"; } echo str_replace("-", "", $stats['STREAK']); ?></span></li>
				<li class="list-group-item" data-toggle="popover" data-container="body" data-placement="top" data-trigger="hover" data-html="true" data-title="Playtime:" data-content="<?php echo $fullplaystring; ?>"><b>Playtime:</b> <span class="label label-info pull-right"><?php echo $playstring; ?></span></li>
				<li class="list-group-item"><b>Most Kills:</b> <span class="label label-success pull-right"><?php if ($enemykills[0] == "") { echo "</span><p class=\"pull-right\">Nobody!</p>"; } else { echo $enemykills[0] . "</span>"; }?></li>
				<li class="list-group-item"><b>Most Deaths:</b> <span class="label label-danger pull-right"><?php if ($enemydeaths[0] == "") { echo "</span><p class=\"pull-right\">Nobody!</p>"; } else { echo $enemydeaths[0] . "</span>"; }?></li>
				<li class="list-group-item"><b>Page Views:</b> <span class="label label-primary pull-right"><?php echo $stats['PAGEVIEWS']; ?></span></li>
			</ul>
		</div>
		<div class="col-sm-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				Recent encounters:
			</div>
			<div class="panel-body">
				Here's a list of the latest <?php if ($stats['KILLS'] + $stats['DEATHS'] < 25) { echo $stats['KILLS'] + $stats ['DEATHS']; } else { echo 25; } ?> pvp encounters <?php echo $username; ?> has had!
			</div>
			<table class="table table-bordered" style="margin-bottom:0px;min-width:820px;">
				<thead>
					<tr class="active">
						<th width="10px" style="min-width:165px;">Date & Time</th>
						<th>Winner</th>
						<th width="167px">Winner health</th>
						<th>Loser</th>
						<th width="80px" style="min-width:80px;">Weapon</th>
						<!--<th>Arena</th>-->
					</tr>
				</thead>
				<tbody>
				<?php
					require('westsworld.datetime.class.php');
					require('timeago.inc.php');

					$getpvplog = mysqli_query($db, "SELECT * FROM kill_log WHERE WIN_USER='$username' OR LOSE_USER='$username' ORDER BY DATE_TIME DESC LIMIT 25");
					while ($list = mysqli_fetch_array($getpvplog)) {
						$datetimeold = str_replace(" ", " @ ", $list["DATE_TIME"]);

						$year = substr($datetimeold, 0, 4);
						$month = substr($datetimeold, 5, 2);
						$day = substr($datetimeold, 8, 2);
						$time = substr($datetimeold, 12, 9);
						$datetime = $day . "-" . $month . "-" . $year . " @ " . $time;
						$health = 5 * $list['WIN_HEALTH'];

						include 'weapon.php';
						
						$timeago = new TimeAgo();

						if ($list['LOSE_USER'] == $username) {
							echo "<tr class='danger'>";
						} else {
							echo "<tr class='success'>";
						}

						if ($list['WIN_USER'] == $username) {
							$winner = "<b>" . $list['WIN_USER'] . "</b>";
						} else {
							$winner = "<a href=\"player?name=" . $list['WIN_USER'] . "\">" . $list['WIN_USER'] . "</a>";
						}
						if ($list['LOSE_USER'] == $username) {
							$loser = "<b>" . $list['LOSE_USER'] . "</b>";
						} else {
							$loser = "<a href=\"player?name=" . $list['LOSE_USER'] . "\">" . $list['LOSE_USER'] . "</a>";
						}
						echo "<td data-toggle='popover' data-container='body' data-placement='right' data-content='$datetime' data-trigger='hover'>" . $timeago->inWords($list['DATE_TIME']) . " ago</td><td>" . $winner . "</td><td><div class='hearts h-" . $health . "'></div></td><td>" . $loser . "</td>" . $weapon /* ."<td><a href='arena?name=" . $list['LOCATION'] . "'>" . $list['LOCATION'] . "</a></td>"*/;
						echo "</tr>";
									}
						echo '
				</tbody>
			</table>';
		}
				?>
		</div>
		</div>
		<br>
	</div>
	<?php include 'footer.php'; ?>
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script>
		$(function(){
				$("[data-toggle='popover']").popover();
			});
	</script>
</body>
</html>