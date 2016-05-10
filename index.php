<?php 
	$nav = file_get_contents('header.php');
	$nav = str_replace('<li class="active">', '<li>', $nav);
	$nav = str_replace('</head>', '<style>.huge { font-size: 75px; margin:50px; }</style></head>', $nav);
	echo $nav;
?>
	<div class="container text-center">
		<h1>Crewniverse Factions <small>PvP Statistics</small></h1>
		<hr>
		<?php if(isset($_GET['new'])) { ?><img class="img-rounded" src="http://cl.ly/image/47171I3C2K2t/newspawn.png" width="100%"><?php } else { ?>
		<h4 class="text-danger">Disclaimer:<br>This Project is maintained / developed by censink, aFreshKiwi and ZRC2011.
		<br><b><u>You should NOT jump to the conclusion this will be added to Crewniverse.</u></b>
		<br>Do NOT spread rumors around this anywhere in the crewniverse community.</h4>
		Enjoy.
		<?php } ?>
		<hr>
		<div class="col-md-4">
			<div class="thumbnail">
				<div class="caption">
					<h3>Real-time Stats!</h3>
				</div>
				<i class="glyphicon glyphicon-time huge"></i>
				<div class="caption"><b><p>All our statistics are 100% live!<br>As soon as a player gets killed, this website will know.<hr>Our Pages update themselves every 30 seconds, but you can refresh the page yourself too!</p></b></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="thumbnail">
				<div class="caption">
					<h3>Top-10!</h3>
				</div>
				<table class="table table-striped table-condensed col-xs-4">
					<thead>
						<tr>
							<th>#</th>
							<th>Username</th>
							<th>ELO</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						require 'db/connect.php'; 
						$getlist = mysqli_query($db, "SELECT * FROM player ORDER BY ELO DESC,KILLS DESC,DEATHS ASC,PLAYTIME ASC LIMIT 10");
						$position = 1;
						while ($list = mysqli_fetch_array($getlist)) {
							echo "<tr>";
							echo "<td>" . $position++ . "</td>";
							echo "<td><a href=\"player?name=" . $list['USERNAME'] . "\">" . $list['USERNAME'] . "</td>";
							echo "<td>" . $list['ELO'] . "</td>";
							echo "<tr>";
						}
						?>
					</tbody>
				</table>
				<div class="caption">
					<a href="top" class="btn btn-lg btn-primary">See Full Leaderboards!</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="thumbnail">
				<div class="caption"><h3>ELO?</h3></div>
				<i class="glyphicon glyphicon-stats huge"></i>
				<div class="caption"><b><p>We make use of an advanced skill rating system called ELO!<br>It gives a much more accurate description of a user's level of skill than a kill/death ratio would.<hr>Kill a <span class="text-success">high-ranked player</span>, and you will earn a lot of ELO points.<hr>Kill a <span class="text-danger">low-ranked player</span>, and you will earn less ELO points!</p></b></div>
			</div>
		</div>
	</div>
	<?php include 'footer.php'; ?>
</body>
</html>