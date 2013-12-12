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
	foreach ( $potatoes as $potato ) {
		if ( $potato->done == "no" ) {
			$activePotatoes[] = $potato;
		}
	}
	return $activePotatoes;
}

function getInactivePotatoes($potatoes) {
	foreach ( $potatoes as $potato ) {
		if ( $potato->done == "yes" ) {
			$activePotatoes[] = $potato;
		}
	}
	return $activePotatoes;
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

function generateMessage($releaseName, $holder, $step, $to, $notes) { 
	$NeededSteps = '';
	$NextInLine = '';

	if ($step=="1") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'QA';
	}
	if ($step=="2") {
		$NeededSteps = '2. Pull everything from Git, create package on...';
		$NextInLine = 'ReleaseManager';
	}
	if ($step=="P") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'QA';
	}
	if ($step=="3") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'QA';
	}
	if ($step=="4") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'QA';
	}
	if ($step=="5") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'QA';
	}
	if ($step=="6") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'QA';
	}
	if ($step=="T") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'QA';
	}
	if ($step=="7") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'QA';
	}
	if ($step=="8") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'QA';
	}
	if ($step=="9") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'QA';
	}
	if ($step=="10") {
		$NeededSteps = '1. Deploy the package to the Stage Environments.<br/>
		2. Restart IIS on each Stage server.<br/>
		3. Smoke test the environments.<br/>';
		$NextInLine = 'Done!';
	}
	$XML = simplexml_load_file("templates/".$step.".xml");
	$NeededSteps = '';
	print_r($XML);
	$i = 0;
	foreach ($XML->steps->step as $step) {
		$i++;
		$NeededSteps .= $i.". ".$step."<br/>";
	}
	return '
	<html>
	<head>
		<title>Release Has Been Passed</title>
	</head>
	<body>
		<h1>Release: ' . $releaseName . '</h1>
		<p>Passed to: '. $holder .'<br/>
		Current Step: <b>'.getFullDescription($step) .'</b><br/>
		</p>
		<p><i><b>What needs to be done before passing:</b></i><br/>
		' . $NeededSteps . '
		<br/>
		<b><i>When finished, pass to ' . $NextInLine . '</i></b><br/><br/>
		Notes from Passer: ' . $notes . '
		</p>
	</body>
	</html>
	';
}

function potatomail($releaseName, $holder, $step, $to, $notes) {
    $smtpserver = 'alemail.angieslist.com';
	$port = 25;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$subject = $releaseName." PASSED TO ".$holder." : Current Step - ".$step;
	// Additional headers
	$headers .= 'To: ' . $to . "\r\n";
	$headers .= 'From: Release Notifier <noreply@angieslist.com.com>' . "\r\n";

	ini_set('SMTP', $smtpserver);
	ini_set('smtp_port', $port);
	$message = generateMessage($releaseName, $holder, $step, $to, $notes);
	$wordwrappedmessage = wordwrap($message, 70);
	$success = mail($to, $subject, $wordwrappedmessage, $headers);
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

?>