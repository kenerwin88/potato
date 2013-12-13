/*
* ::AVAILABLE VARIABLES::
*
* RELEASEDIRECTORY - Path to Potatoes
* CURRENTDATE - The date as of RIGHT now
* $done - Boolean of selected potato status
* $potatoes - ALL potatoes in RELEASEDIRECTORY
* $activePotatoes; - ONLY the active (non done) potatoes
* $inactivePotatoes; - ONLY the inactive (finished) potatoes
* $selectedPotato - The currently selected potato
*
*/
						<!-- The METER -->
			    		<!--
			    		<div class="meter">
			    		<?php
			    		if ($selectedPotato) {
			    		foreach ($selectedPotato->timeLine as $Segment) {
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
			    				
			    				if ($Segment === reset($selectedPotato->timeLine)) {
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
			    				if ($Segment === reset($selectedPotato->timeLine)) {
			    					echo "<span class=\"".$color." first\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">".$shortName." - ".$percent."</center></span>";
			    				}
			    				
			    				else {
			    					echo "<span class=\"".$color."\" style=\"width: ".$percentWidth."; display: inline-block;\"><center style=\"color: #fff\">".$shortName." - ".$percent."</center></span>";
			    				}
			    			}
			    		}
			    		$t = timeDifference($selectedPotato->goalLaunchDate, CURRENTDATE);
			    		if ($selectedPotato->done=='yes') {
			    			$t = timeDifference($selectedPotato->goalLaunchDate, $selectedPotato->getLastSegment()->endDate);
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
			    		