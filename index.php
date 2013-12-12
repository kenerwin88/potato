<?php
include 'header.php';

/*
* Potato Loader
*
* Info: Returns array of Potatoes
*/

if (isset($_GET['currentPotato'])) {
		$CurrentPotato = getCurrentPotato($_GET['currentPotato'], $Potatoes);
		if (isset($CurrentPotato)) {
			$arrayValues = array_values($CurrentPotato->timeLine);
			$TheLastSegment = end($arrayValues);
		}
		else {
			echo "That release package no longer exists, are you sure it wasn't closed?";
		}
	}
	else {$CurrentPotato = false;}
?>

<!-- Determine if in OVERTIME -->
<?php 
if ($CurrentPotato) {
	$totalTime = timeDifference($CurrentPotato->goalLaunchDate, $CurrentPotato->startDate);
	$t = timeDifference($CurrentPotato->goalLaunchDate, date('l, m/d/Y H:i:s'));
	$percent = ($t / $totalTime * 100);
	$Overtime = FALSE;
	if ($percent <= 0) {
		$Overtime = TRUE;
		$totalTime = timeDifference(date('l, m/d/Y H:i:s'), $CurrentPotato->startDate);
	}
}
?>
<!-- END OVERTIME Code -->


<?php
$PERCENTEXCESS = 0;
if (!empty($_POST['submit'])) {
	$TheLastSegment = end(array_values($CurrentPotato->timeLine));
	$TheLastSegment->endDate = date('l, m/d/Y H:i:s');
	$SegmentObj = new Segment($_POST['Team'],$_POST['Step'],date('l, m/d/Y H:i:s'),'N/A', $_POST['notes']);
	$CurrentTeam = $_POST['Team'];
	$CurrentPotato->timeLine[] = $SegmentObj;
	$Holder = "N/A";
	if ($CurrentTeam=="ReleaseManager") {$Holder = $CurrentPotato->ReleaseManager;}
	if ($CurrentTeam=="SiteOps") {$Holder = $CurrentPotato->SiteOps;}
	if ($CurrentTeam=="BuildAndRelease") {$Holder = $CurrentPotato->BuildAndRelease;}
	if ($CurrentTeam=="QA") {$Holder = $CurrentPotato->QA;}

	potatomail($CurrentPotato->name, $Holder, $_POST['Step'], $CurrentPotato->SiteOps, $_POST['notes']);

	if ($_POST['Step']=="10") {
		$done=TRUE;
	}
}

?>
<html>
	<head>
		<title>Potato - Deployment Tracker</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<?php
		if ($done) {
			echo '<meta http-equiv="refresh" content="5; URL=index.php" />';
		}
		?>
	</head>
	<body>
		<div id="wrapper">
			<header>
				<a href="index.php"><img src="images/logo.png" /></a>
				<h2>Potato</h2>
			</header>
			<div id="PotatoHeader">
				<div id="Version">
					<a href="index.php"><img src="images/character.png" /></a>
					<h1>
						<?php
						if ($CurrentPotato) {
							if ($Overtime) {
								echo '<span style="color: red;">';
								echo $CurrentPotato->name;
								echo '<h6>Start Date: ',$CurrentPotato->startDate,'</h6>';
								echo '<h6>Goal Date: ',$CurrentPotato->goalLaunchDate,'</h6>';
								echo '</span>';
							}
							else {
								echo $CurrentPotato->name;
								echo '<h6>Start Date: ',$CurrentPotato->startDate,'</h6>';
								echo '<h6>Goal Date: ',$CurrentPotato->goalLaunchDate,'</h6>';
							}
							
						}
						else {
							echo 'No Potato Selected';
							echo '<h6>Start Date: N/A</h6>';
							echo '<h6>Goal Date: N/A</h6>';
						}
						?>
					</h1>
					
				</div>
				<div id="Team">
					<h6 style="color: #f1a165;">Build &amp; Release: jodyt@angieslist.com</h6>
					<h6 style="color: #2e52b8;">SiteOps: kener@angieslist.com</h6>
					<h6 style="color: #2da84a;">Release Manager: carrie@angieslist.com</h6>
					<h6 style="color: #b82ea0;">QA: andreww@angieslist.com</h6>
				</div>
			</div>
			<div id="content">
				<div id="navigation">
					<div class="padding">
						<h1>Switch Active Potato</h1>
						<?php
						foreach ($Potatoes as $Potato) {
							echo "<h4><a href=\"index.php?currentPotato=".$Potato->name."\">".$Potato->name."</a></h4>";
						}
						?>
						<h4>Notes</h4>
						<h1><a href="create.php">Create Release</a></h1>
						<h1>View Historical</h1>
					</div>
				</div>
				<div id="page">
					<div class="padding">
						<h1>Summary</h1>
						

						<!-- The METER -->
			    		<div class="meter">
			    		<?php
			    		if ($CurrentPotato) {
			    		foreach ($CurrentPotato->timeLine as $Segment) {
			    			$color = 'blue';
			    			if ($Segment->team == "ReleaseManager") {
			    				$color = 'green';
			    				$shortName = 'RM';
			    			}
			    			if ($Segment->team == "SiteOps") {
			    				$color = 'blue';
			    				$shortName = 'Ops';
			    			}
			    			if ($Segment->team == "BuildAndRelease") {
			    				$color = 'orange';
			    				$shortName = 'B&amp;R';
			    			}
			    			if ($Segment->team == "QA") {
			    				$color = 'purple';
			    				$shortName = 'QA';
			    			}
			    			if ($Segment->endDate !== "N/A") {
			    				$timePassed = timeDifference($Segment->endDate, $Segment->startDate);
			    				$percent = round($timePassed / $totalTime * 100, 2)."%";
			    				$pWidth = round($timePassed / $totalTime * 99, 2);
			    				if ($pWidth < 0.5) {
			    					$percentWidth = "0.5%";
			    					$PERCENTEXCESS+=0.5;
			    				} # Make even 1 second look real
			    				else {
			    					$percentWidth = round($timePassed / $totalTime * 98, 2)."%";
			    				}
			    				
			    				if ($Segment === reset($CurrentPotato->timeLine)) {
			    					echo "<span class=\"".$color." first\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">".$shortName." - ".$percent."</center></span>";
			    				}

			    				else {
			    					echo "<span class=\"".$color."\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">".$shortName." - ".$percent."</center></span>";
			    				}
			    			}
			    			else {
			    				$timePassed = timeDifference(date('l, m/d/Y H:i:s'),$Segment->startDate);
			    				$percent = round($timePassed / $totalTime * 100, 2)."%";
			    				$pWidth = round($timePassed / $totalTime * 99, 2);
			    				if ($pWidth < 0.5) {
			    					$percentWidth = "0.5%";
			    					$PERCENTEXCESS+=0.5;
			    				} # Make even 1 second look real
			    				else {
			    					$percentWidth = round($timePassed / $totalTime * 98, 2)."%";
			    				}
			    				if ($Segment === reset($CurrentPotato->timeLine)) {
			    					echo "<span class=\"".$color." first\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">".$shortName." - ".$percent."</center></span>";
			    				}
			    				
			    				else {
			    					echo "<span class=\"".$color."\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">".$shortName." - ".$percent."</center></span>";
			    				}
			    			}
			    		}
			    		$t = timeDifference($CurrentPotato->goalLaunchDate, date('l, m/d/Y H:i:s'));
			    		if ($CurrentPotato->done=='yes') {
			    			$t = timeDifference($CurrentPotato->goalLaunchDate, $TheLastSegment->endDate);
			    		}
			    		$percent = round($t / $totalTime * 100, 2)."%";
			    		$percentWidth = round(($t / $totalTime * 99)-$PERCENTEXCESS, 2)."%"; // This is so that the width doesn't accidently go over... ignore

			    		if ($Overtime) {
			    		}
			    		else {
			    			echo "<span class=\"black last\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">Percent Remaining: ".$percent."</center></span>";
			    		}

			    		?>
			    		</div>
			    		<!-- END METER -->
			    		
						<p>Currently held by: <b>
							<?php 
				    		if ($TheLastSegment->team == 'ReleaseManager') {echo $CurrentPotato->ReleaseManager." - ReleaseManager";} 
				    		if ($TheLastSegment->team == 'BuildAndRelease') {echo $CurrentPotato->BuildAndRelease." - Build&amp;Release";} 
				    		if ($TheLastSegment->team == 'SiteOps') {echo $CurrentPotato->SiteOps." - SiteOps";} 
				    		if ($TheLastSegment->team == 'QA') {echo $CurrentPotato->QA." - QA";} 
				    		?>
				    		</b><br/>
				    		Held for: <b><?php 
				    		
				    		$timePassed = timeDifference($TheLastSegment->startDate, date('1, m/d/Y H:i:s'));
				    		
				    		echo secondsToTime($timePassed);
				    		?></b>
				    		<br/>
				    		<?php
				    		echo 'Current Step: <b>',getStep($TheLastSegment->step)."</b>";

				    		echo '<br/>Time until launch: <b>';
				    		if ($Overtime) {
				    			echo "<span style=\"color: red;\">LATE!</span>";
				    		}
				    		else {
				    			echo secondsToTime(timeDifference($CurrentPotato->goalLaunchDate, date('1, m/d/Y H:i:s')));
				    		}
				    		?>
				    		</b>
				    		<?php
				    		/*
				    		foreach ($CurrentPotato->timeLine as $Segment) {
				    			echo "<br/>";
				    			if ($Segment->endDate !== "N/A") {
					    			echo secondsToTime(timeDifference($Segment->endDate, $Segment->startDate));
					    			$timePassed = timeDifference($Segment->endDate, $Segment->startDate);
					    			
					    			echo "Percentage of Total Time: ";
				    				echo round($timePassed / $totalTime * 100, 2)."%";
				    				echo "<br/>";
				    			}
				    			else {

				    				$timePassed = timeDifference(date('l, m/d/Y H:i:s'),$Segment->startDate);
				    				echo secondsToTime($timePassed);
				    				echo "<br/>Total TIME: ".$totalTime."<br/>";
				    				echo "<br/>Seconds for last segment total: ".$timePassed."<br/>";

				    				echo "Percentage of Total Time: ";
				    				echo round($timePassed / $totalTime * 100, 2)."%";

				    			}
				    		}
				    		echo "<br/>From now to launch date: ";
				    		echo $t = timeDifference($Potato->goalLaunchDate, date('l, m/d/Y H:i:s'));
				    		echo $t."<br/>";
				    		echo "<br/><br/>";
				    		echo round($t / $totalTime * 100, 2);
				    		echo "%<br/>";
				    		echo secondsToTime($t);
				    		*/
				    		?>
				    		<center>
				    		<form method="post">
				    		<div id="pass" style="border:2px dotted; border-radius:25px; width: 300px; padding: 10px;">
				    		<h2>Pass <?php echo $CurrentPotato->name ?> <img src="potato.png" /></h2>
				    			Select Team: <br/>
								<select name="Team">
								 	<option value="ReleaseManager">Release Manager</option>
								 	<option value="BuildAndRelease">Build &amp; Release</option>
								 	<option value="SiteOps">Site Ops</option>
								 	<option value="QA">QA</option>
								</select>
								<br/>
				    			Select Step: 
								<select name="Step">
								 	<option value="1">1. Release Manager Provides Pull Request List</option>
								 	<option value="2">2. Build &amp; Release Pulling/Merging</option>
								 	<option value="P">(Optional) B &amp; R Pending Approval from RM</option>
								 	<option value="3">3. Build &amp; Release Building Package</option>
								 	<option value="4">4. SiteOps Deploying Package</option>
								 	<option value="5">5. Release Manager Notified</option>
								 	<option value="6">6. QA - Ready for Testing</option>
								 	<option value="T">(OPTIONAL) SiteOps troubleshooting QA Issue</option>
								 	<option value="7">7. SiteOps Given Greenlight, Prodstaging</option>
								 	<option value="8">8. SiteOps Prodstage Complete, WAITING</option>
								 	<option value="9">9. SiteOps Deploying Package</option>
								 	<option value="10">10. DONE</option>
								</select>
								<br/><br/>
								Additional Notes: <br/><textarea name="notes" rows="4" cols="30"></textarea></br>
								<input type="hidden" name="PotatoVersion" value="<?php echo $Potato->name ?>">
								<input type="submit" name="submit" value="Pass Potato" />
				    		</div>
				    		</form>
				    		</center>
				    		
							<?php
							$CurrentPotatoFileName = "potatoes/potato-".$CurrentPotato->name.".xml";
							$donePotatoFileName = "potatoes/potato-".$CurrentPotato->name."-DONE.xml";
							if ($done) {
							   	sleep(1);
							   	rename($CurrentPotatoFileName, $donePotatoFileName);
				    			echo "THIS RELEASE HAS BEEN COMPLETED, REDIRECTING TO MAIN INDEX in 5 SECONDS!";
				    			$CurrentPotatoFileName = $donePotatoFileName;
				    		}
							
							   $writer = new XMLWriter();  
							   $writer->openURI($CurrentPotatoFileName);   
							   $writer->setIndent(true);
							   $writer->setIndentString("    ");
							   $writer->startElement('xml');  
						       $writer->writeElement('name', $CurrentPotato->name);  
						       $writer->writeElement('startDate', $CurrentPotato->startDate);
						       $writer->writeElement('goalLaunchDate', $CurrentPotato->goalLaunchDate);
						       if ($done) {$writer->writeElement('done', 'yes');}
						       else {$writer->writeElement('done', $CurrentPotato->done);}
						       $writer->writeElement('status', $CurrentPotato->status);
						       $writer->writeElement('ReleaseManager', $CurrentPotato->ReleaseManager);
						       $writer->writeElement('BuildAndRelease', $CurrentPotato->BuildAndRelease);
						       $writer->writeElement('SiteOps', $CurrentPotato->SiteOps);
						       $writer->writeElement('QA', $CurrentPotato->QA);
						           $writer->startElement('timeline');
						           foreach ($CurrentPotato->timeLine as $Segment) {
						           	$writer->startElement('segment');
							           	$writer->writeElement('team', $Segment->team);
							           	$writer->writeElement('step', $Segment->step);
							           	$writer->writeElement('startDate', $Segment->startDate);
							           	$writer->writeElement('endDate', $Segment->endDate);
							           	$writer->writeElement('notes', $Segment->notes);
						           	$writer->endElement();
						           }
						           $writer->endElement();
						       $writer->endElement();
							   $writer->endDocument();   
							   $writer->flush(); 
							   
							?>

				    		<?php
				    		
				    		}

				    		else {
				    			echo "Please select a release!";
				    		}
				    		?>

						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>