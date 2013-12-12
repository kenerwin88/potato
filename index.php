<?php
include 'header.php';

if (isset($_GET['currentPotato'])) {
		$SelectedPotato = getCurrentPotato($_GET['currentPotato'], $activePotatoes);
		if (isset($SelectedPotato)) {
			$arrayValues = array_values($SelectedPotato->timeLine);
			$TheLastSegment = end($arrayValues);
		}
		else {
			echo "That release package no longer exists, are you sure it wasn't closed?";
		}
	}
	else {$SelectedPotato = false;}


?>

<!-- Determine if in OVERTIME -->
<?php 
if ($SelectedPotato) {
	$totalTime = timeDifference($SelectedPotato->goalLaunchDate, $SelectedPotato->startDate);
	$t = timeDifference($SelectedPotato->goalLaunchDate, CURRENTDATE);
	$percent = ($t / $totalTime * 100);
	$Overtime = FALSE;
	if ($percent <= 0) {
		$Overtime = TRUE;
		$totalTime = timeDifference(CURRENTDATE, $SelectedPotato->startDate);
	}
}
?>
<!-- END OVERTIME Code -->


<?php
$PERCENTEXCESS = 0;
if (!empty($_POST['submit'])) {
	$TheLastSegment = $SelectedPotato->getLastSegment();
	$TheLastSegment->endDate = CURRENTDATE;
	$SegmentObj = new Segment($_POST['Team'],$_POST['Step'],CURRENTDATE,'N/A', $_POST['notes']);
	$CurrentTeam = $_POST['Team'];
	$SelectedPotato->timeLine[] = $SegmentObj;
	$Holder = "N/A";
	if ($CurrentTeam=="ReleaseManager") {$Holder = $SelectedPotato->ReleaseManager;}
	if ($CurrentTeam=="SiteOps") {$Holder = $SelectedPotato->SiteOps;}
	if ($CurrentTeam=="BuildAndRelease") {$Holder = $SelectedPotato->BuildAndRelease;}
	if ($CurrentTeam=="QA") {$Holder = $SelectedPotato->QA;}

	potatomail($SelectedPotato->name, $Holder, $_POST['Step'], $SelectedPotato->SiteOps, $_POST['notes']);

	if ($_POST['Step']=="10") {
		$done=TRUE;
	}
}

?>
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
						if ($SelectedPotato) {
							if ($Overtime) {
								echo '<span style="color: red;">';
								echo $SelectedPotato->name;
								echo '<h6>Start Date: ',$SelectedPotato->startDate,'</h6>';
								echo '<h6>Goal Date: ',$SelectedPotato->goalLaunchDate,'</h6>';
								echo '</span>';
							}
							else {
								echo $SelectedPotato->name;
								echo '<h6>Start Date: ',$SelectedPotato->startDate,'</h6>';
								echo '<h6>Goal Date: ',$SelectedPotato->goalLaunchDate,'</h6>';
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
					<h6 style="color: #f1a165;">Build &amp; Release: <?php echo $SelectedPotato->getPerson('BuildAndRelease') ?></h6>
					<h6 style="color: #2e52b8;">SiteOps: <?php echo $SelectedPotato->getPerson('SiteOps') ?></h6>
					<h6 style="color: #2da84a;">Release Manager: <?php echo $SelectedPotato->getPerson('ReleaseManager') ?></h6>
					<h6 style="color: #b82ea0;">QA: <?php echo $SelectedPotato->getPerson('QA') ?></h6>
				</div>
			</div>
			<div id="content">
				<div id="navigation">
					<div class="padding">
						<h1>Switch Active Potato</h1>
						<?php
						foreach ($activePotatoes as $Potato) {
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
			    		if ($SelectedPotato) {
			    		foreach ($SelectedPotato->timeLine as $Segment) {
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
			    				
			    				if ($Segment === reset($SelectedPotato->timeLine)) {
			    					echo "<span class=\"".$color." first\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">".$shortName." - ".$percent."</center></span>";
			    				}

			    				else {
			    					echo "<span class=\"".$color."\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">".$shortName." - ".$percent."</center></span>";
			    				}
			    			}
			    			else {
			    				$timePassed = timeDifference(CURRENTDATE,$Segment->startDate);
			    				$percent = round($timePassed / $totalTime * 100, 2)."%";
			    				$pWidth = round($timePassed / $totalTime * 99, 2);
			    				if ($pWidth < 0.5) {
			    					$percentWidth = "0.5%";
			    					$PERCENTEXCESS+=0.5;
			    				} # Make even 1 second look real
			    				else {
			    					$percentWidth = round($timePassed / $totalTime * 98, 2)."%";
			    				}
			    				if ($Segment === reset($SelectedPotato->timeLine)) {
			    					echo "<span class=\"".$color." first\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">".$shortName." - ".$percent."</center></span>";
			    				}
			    				
			    				else {
			    					echo "<span class=\"".$color."\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">".$shortName." - ".$percent."</center></span>";
			    				}
			    			}
			    		}
			    		$t = timeDifference($SelectedPotato->goalLaunchDate, CURRENTDATE);
			    		if ($SelectedPotato->done=='yes') {
			    			$t = timeDifference($SelectedPotato->goalLaunchDate, $TheLastSegment->endDate);
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
			    		
						<p>Currently held by: <b><?php echo $SelectedPotato->getPersonHolding() . " - " . $SelectedPotato->getTeamHolding(); ?></b></p>
						<p>Held for: <b><?php 
				    		
				    		$timePassed = timeDifference($TheLastSegment->startDate, CURRENTDATE);
				    		
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
				    			echo secondsToTime(timeDifference($SelectedPotato->goalLaunchDate, date('1, m/d/Y H:i:s')));
				    		}
				    		?>
				    		</b>
				    		<center>
				    		<form method="post">
				    		<div id="pass" style="border:2px dotted; border-radius:25px; width: 300px; padding: 10px;">
				    		<h2>Pass <?php echo $SelectedPotato->name ?> <img src="images/potato.png" /></h2>
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
							$SelectedPotatoFileName = "potatoes/potato-".$SelectedPotato->name.".xml";
							$donePotatoFileName = "potatoes/potato-".$SelectedPotato->name."-DONE.xml";
							if ($done) {
							   	sleep(1);
							   	rename($SelectedPotatoFileName, $donePotatoFileName);
				    			echo "THIS RELEASE HAS BEEN COMPLETED, REDIRECTING TO MAIN INDEX in 5 SECONDS!";
				    			$SelectedPotatoFileName = $donePotatoFileName;
				    		}
							
							   $writer = new XMLWriter();  
							   $writer->openURI($SelectedPotatoFileName);   
							   $writer->setIndent(true);
							   $writer->setIndentString("    ");
							   $writer->startElement('xml');  
						       $writer->writeElement('name', $SelectedPotato->name);  
						       $writer->writeElement('startDate', $SelectedPotato->startDate);
						       $writer->writeElement('goalLaunchDate', $SelectedPotato->goalLaunchDate);
						       if ($done) {$writer->writeElement('done', 'yes');}
						       else {$writer->writeElement('done', $SelectedPotato->done);}
						       $writer->writeElement('status', $SelectedPotato->status);
						       $writer->writeElement('ReleaseManager', $SelectedPotato->ReleaseManager);
						       $writer->writeElement('BuildAndRelease', $SelectedPotato->BuildAndRelease);
						       $writer->writeElement('SiteOps', $SelectedPotato->SiteOps);
						       $writer->writeElement('QA', $SelectedPotato->QA);
						           $writer->startElement('timeline');
						           foreach ($SelectedPotato->timeLine as $Segment) {
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