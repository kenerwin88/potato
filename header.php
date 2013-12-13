<?php
# Enable all errors, we want clean code
error_reporting(E_ALL);
ini_set("display_errors", 1);

# Includes
include 'functions.php';
include 'classes/task.php';
include 'classes/step.php';
include 'classes/potato.php';
include 'classes/segment.php';

# Declare Constants
define('RELEASEDIRECTORY', 'potatoes/');  
define('CURRENTDATE', date('l, m/d/Y H:i:s')); 

# Declare Variables
$done = false; 

# Get Potatoes
$potatoes = getPotatoes();
$activePotatoes = getActivePotatoes($potatoes);
$inactivePotatoes = getInactivePotatoes($potatoes);
$selectedPotato = getSelectedPotato($activePotatoes);

if ($selectedPotato) {
	$totalTime = $selectedPotato->getSecondsFromStartToLaunch();
	$t = timeDifference($selectedPotato->goalLaunchDate, CURRENTDATE);
	$percent = ($t / $totalTime * 100);
	$Overtime = FALSE;
	if ($percent <= 0) {
		$Overtime = TRUE;
		$totalTime = timeDifference(CURRENTDATE, $selectedPotato->startDate);
	}
}

$PERCENTEXCESS = 0; # This variable needs to go away, it currently sorta determines the width of things.
$selectedPotato = processPOST($_POST, $selectedPotato); # Do processing on any POST variables.
?>
<!DOCTYPE HTML>
	<html>
		<head>
			<title>Potato - Deployment Tracker</title>
			<link rel="stylesheet" type="text/css" href="css/style.css">
			<?php if ($done) {echo '<meta http-equiv="refresh" content="5; URL=index.php" />';} ?>
		</head>
		<body>
			<div id="wrapper">
				<header>
					<a href="index.php"><img src="images/logo.png" alt="logo" /></a>
					<h2>Potato</h2>
				</header>
				<div id="PotatoHeader">
					<div id="Version">
						<a href="index.php"><img src="images/character.png" alt="character" /></a>
			
								<?php
								if ($selectedPotato) {
									if ($Overtime) {
										echo '<span style="color: red;">';
										echo '<h1>' . $selectedPotato->name . '</h1>';
										echo '<h6>Start Date: ',$selectedPotato->startDate,'</h6>';
										echo '<h6>Goal Date: ',$selectedPotato->goalLaunchDate,'</h6>';
										echo '</span>';
									}
									else {
										echo '<h1>' . $selectedPotato->name . '</h1>';
										echo '<h6>Start Date: ',$selectedPotato->startDate,'</h6>';
										echo '<h6>Goal Date: ',$selectedPotato->goalLaunchDate,'</h6>';
									}
									
								}
								else {
									echo 'No Potato Selected';
									echo '<h6>Start Date: N/A</h6>';
									echo '<h6>Goal Date: N/A</h6>';
								}
								?>
					
					</div>
					<?php if ($selectedPotato) { ?>
					<div id="Team">
						<h6 style="color: #f1a165;">Build &amp; Release: <?php echo $selectedPotato->getPerson('BuildAndRelease') ?></h6>
						<h6 style="color: #2e52b8;">SiteOps: <?php echo $selectedPotato->getPerson('SiteOps') ?></h6>
						<h6 style="color: #2da84a;">Release Manager: <?php echo $selectedPotato->getPerson('ReleaseManager') ?></h6>
						<h6 style="color: #b82ea0;">QA: <?php echo $selectedPotato->getPerson('QA') ?></h6>
					</div>
					<?php } ?>
				</div>
							<div id="content">
					<div id="navigation">
						<div class="padding">
							<h1>Switch Active Potato</h1>
							<?php
							foreach ($activePotatoes as $Potato) {
								echo "<h4><a href=\"index.php?selectedPotato=".$Potato->name."\">".$Potato->name."</a></h4>";
							}
							?>
							<h4>Notes</h4>
							<h1><a href="create.php">Create Release</a></h1>
							<h1>View Historical</h1>
						</div>
					</div>
					<div id="page">
						<div class="padding">