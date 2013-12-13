<?php include 'header.php'; ?>
	
			<div id="PotatoHeader">
				<div id="Version">
					<a href="index.php"><img src="images/character.png" /></a>
					<h1>
						<?php
						if ($selectedPotato) {
							if ($Overtime) {
								echo '<span style="color: red;">';
								echo $selectedPotato->name;
								echo '<h6>Start Date: ',$selectedPotato->startDate,'</h6>';
								echo '<h6>Goal Date: ',$selectedPotato->goalLaunchDate,'</h6>';
								echo '</span>';
							}
							else {
								echo $selectedPotato->name;
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
					</h1>
					
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
						<h1>Summary</h1>
						
	
						<p>Currently held by: <b><?php echo $selectedPotato->getPersonHolding() . " - " . $selectedPotato->getTeamHolding(); ?></b></p>
						<p>Held for: <b><?php 
				    		
				    		$timePassed = timeDifference($selectedPotato->getLastSegment()->startDate, CURRENTDATE);
				    		
				    		echo secondsToTime($timePassed);
				    		?></b>
				    		<br/>
				    		<?php
				    		echo 'Current Step: <b>',getStep($selectedPotato->getLastSegment()->step).'</b>';
				    		echo '<br/>Seconds from Start Date to Launch Date: <b>' . $selectedPotato->getSecondsFromStartToLaunch().'</b>';
				    		echo '<br/>Time from Start Date to Launch Date: <b>' . $selectedPotato->getTimeFromStartToLaunch().'</b>';
				    		echo '<br/>Seconds from Start Date to Now: <b>' . $selectedPotato->getSecondsFromStartToNow().'</b>';
				    		echo '<br/>Time from Start Date to Now: <b>' . $selectedPotato->getTimeFromStartToNow().'</b>';
				    		
				    		echo '<br/>Time until launch: <b>';
				    		if ($Overtime) {
				    			echo "<span style=\"color: red;\">LATE!</span>";
				    		}
				    		else {
				    			echo secondsToTime(timeDifference($selectedPotato->goalLaunchDate, date('1, m/d/Y H:i:s')));
				    		}
				    		?>
				    		</b>
				    		<center>
				    		<form method="post">
				    		<input type="hidden" name="page" id="page" value="index" />
				    		<div id="pass" style="border:2px dotted; border-radius:25px; width: 300px; padding: 10px;">
				    		<h2>Pass <?php echo $selectedPotato->name ?> <img src="images/potato.png" /></h2>
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
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>