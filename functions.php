<?php


date_default_timezone_set('America/Indiana/Indianapolis'); # Set timezone to make sure everything is accurate.

function loadPotato( $xml ) {
	$PotatoXML = simplexml_load_file( $xml );
	foreach ($PotatoXML->timeline->segment as $segment) {
		$timeLine[] = new Segment($segment->team, $segment->step, $segment->startDate, $segment->endDate, $segment->notes);
	}
	return new Potato( $PotatoXML->name, $PotatoXML->status, $PotatoXML->lastChanged, $PotatoXML->startDate, 
		               $PotatoXML->goalLaunchDate, $timeLine, $PotatoXML->ReleaseManager, $PotatoXML->BuildAndRelease, 
		               $PotatoXML->SiteOps, $PotatoXML->QA, $PotatoXML->done );
}

function getCurrentPotato($potatoName, $potatoes) {
	foreach ($potatoes as $potato) {
		if ($potato->name == "$potatoName") {
			return $potato;
		}
	}
}

function getPotatoes() {
	$releaseDirectoryScan = array_diff( scandir(RELEASEDIRECTORY), array('..', '.') );
	foreach( $releaseDirectoryScan as $file ) {
			$potatoes[] = loadPotato( "potatoes/".$file );
	}
	return $potatoes;
}

function getActivePotatoes($potatoes) {
	$activePotatoes = array();
	foreach ( $potatoes as $potato ) {
		if ( $potato->done == "no" ) {
			$activePotatoes[] = $potato;
		}
	}
	return $activePotatoes;
}

function getInactivePotatoes($potatoes) {
	$inactivePotatoes = array();
	foreach ( $potatoes as $potato ) {
		if ( $potato->done == "yes" ) {
			$inactivePotatoes[] = $potato;
		}
	}
	return $inactivePotatoes;
}


function getSelectedPotato($activePotatoes) {
	if (isset($_GET['selectedPotato'])) {
		return getCurrentPotato($_GET['selectedPotato'], $activePotatoes);
	}
	else {return false;}
}

function loadSteps( $xml ) {

	$stepXML = simplexml_load_file( $xml );

	foreach ( $stepXML->step as $step ) {
		foreach ( $step->tasks->task as $task ) {
			$taskList[] = new Task( $task->description, $task->url );
		}
		$stepArray[] = new Step( $step->id, $step->name, $taskList );
	}

	return $stepArray;
}

function getFullDescription($number) {
	if ($number == "1") {return '1. Release Manager Provides Pull Request List';}
	else if ($number == "2") {return '2. Build &amp; Release Pulling/Merging';}
	else if ($number == "P") {return '(Optional) B &amp; R Pending Approval from RM';}
	else if ($number == "3") {return '3. Build &amp; Release Building Package';}
	else if ($number == "4") {return '4. SiteOps Deploying Package';}
	else if ($number == "5") {return '5. Release Manager Notified';}
	else if ($number == "6") {return '6. QA - Ready for Testing';}
	else if ($number == "T") {return '(OPTIONAL) SiteOps troubleshooting QA Issue';}
	else if ($number == "7") {return '7. SiteOps Given Greenlight, Prodstaging';}
	else if ($number == "8") {return '8. SiteOps Prodstage Complete, WAITING';}
	else if ($number == "9") {return '9. SiteOps Deploying Package';}
	else if ($number == "10") {return '10. DONE';}
}

function generateEmail($potato, $template, $to) {
	$message = file_get_contents("templates/".$template.".html");
	$XML = simplexml_load_file("templates/".$template.".html");
	$subject = (string)$XML->head->title;
	
	$message = populateData( $potato, $message );
	$subject = populateData( $potato, $subject );

	$smtpserver = 'alemail.angieslist.com';
	$port = 25;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'To: ' . $to . "\r\n";
	$headers .= 'From: Release Notifier <noreply@angieslist.com.com>' . "\r\n";

	ini_set('SMTP', $smtpserver);
	ini_set('smtp_port', $port);

	$wordwrappedmessage = wordwrap($message, 70);
	$success = mail($to, $subject, $wordwrappedmessage, $headers);

}

// Populates string with information from Potato
function populateData( $potato, $string ) {
	$string = str_replace("%RELEASENAME%", $potato->name, $string);
	$string = str_replace("%TEAMHOLDING%", $potato->getTeamHolding(), $string);
	$string = str_replace("%PERSONHOLDING%", $potato->getPersonHolding(), $string);
	$string = str_replace("%NOTES%", $potato->getLastSegment()->notes, $string);
	return $string;
}

function getStep($step) {
	switch ($step) {
		case 1:
			echo "1. Release Manager Provides Pull Request List";
			break;
		case 2:
			echo '2. Build &amp; Release Pulling/Merging';
			break;
		case 'P':
			echo '(Optional) B &amp; R Pending Approval from RM';
			break;
		case 3:
			echo '3. Build &amp; Release Building Package';
			break;
		case 4:
			echo '4. SiteOps Deploying Package';
			break;
		case 5:
			echo '5. Release Manager Notified';
			break;
		case 6:
			echo '6. QA - Ready for Testing';
			break;
		case 'T':
			echo '(OPTIONAL) SiteOps troubleshooting QA Issue';
			break;
		case 7:
			echo '7. SiteOps Given Greenlight, Prodstaging';
			break;
		case 8:
			echo '8. SiteOps Prodstage Complete, WAITING';
			break;
		case 9:
			echo '9. SiteOps Deploying Package';
			break;
		case 10:
			echo '10. DONE';
			break;	
		}
	}
function timeDifference($firstDate, $secondDate) {
	$firstDateExplode = explode(",",$firstDate);
	$secondDateExplode = explode(",",$secondDate);
	$firstDate1 = strtotime($firstDateExplode[1]);
	$secondDate1 = strtotime($secondDateExplode[1]);
	$timePassed = $firstDate1 - $secondDate1;
	return $timePassed;
}
function roundTime($seconds) {
	$t = round($seconds);
	return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}
function secondsToTime($seconds) {
    $dtF = new DateTime('UTC');
    $dtT = clone $dtF;
    $dtT->modify("+$seconds seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}

function savePotato($potato) {
	$selectedPotatoFileName = "potatoes/potato-".$potato->name.".xml";
	$donePotatoFileName = "potatoes/potato-".$potato->name."-DONE.xml";
	if ($potato->done=="yes") {
	   	rename($selectedPotatoFileName, $donePotatoFileName);
		echo "THIS RELEASE HAS BEEN COMPLETED, REDIRECTING TO MAIN INDEX in 5 SECONDS!";
		$selectedPotatoFileName = $donePotatoFileName;
	}
   $writer = new XMLWriter();  
   $writer->openURI($selectedPotatoFileName);   
   $writer->setIndent(true);
   $writer->setIndentString("    ");
   $writer->startElement('xml');  
   $writer->writeElement('name', $potato->name);  
   $writer->writeElement('startDate', $potato->startDate);
   $writer->writeElement('goalLaunchDate', $potato->goalLaunchDate);
   if ($potato->done=="yes") {$writer->writeElement('done', 'yes');}
   else {$writer->writeElement('done', $potato->done);}
   $writer->writeElement('status', $potato->status);
   $writer->writeElement('ReleaseManager', $potato->ReleaseManager);
   $writer->writeElement('BuildAndRelease', $potato->BuildAndRelease);
   $writer->writeElement('SiteOps', $potato->SiteOps);
   $writer->writeElement('QA', $potato->QA);
       $writer->startElement('timeline');
       foreach ($potato->timeLine as $Segment) {
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
}

function processPOST( $POST, $selectedPotato ) {
	if (!empty($POST['submit'])) {
		$TheLastSegment = $selectedPotato->getLastSegment();
		$TheLastSegment->endDate = CURRENTDATE;
		$SegmentObj = new Segment($POST['Team'],$POST['Step'],CURRENTDATE,'N/A', $POST['notes']);
		$CurrentTeam = $_POST['Team'];
		$selectedPotato->timeLine[] = $SegmentObj;

		generateEmail($selectedPotato, ("Step-".$POST['Step']), 'kener@angieslist.com');

		# If Potato on last step, complete it!
		if ($POST['Step']=="10") {$selectedPotato->done = TRUE;}
		
		# Save Potato
		savePotato($selectedPotato);
	}
	return $selectedPotato;
}

?>