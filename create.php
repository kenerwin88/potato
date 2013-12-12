<?php
include 'header.php';
$DONE = false;

		if (isset($_POST['submit'])) {
		$GoalLaunchDate = date('l, m/d/Y H:i:s', mktime($_POST['hour'], $_POST['minute'], 0, $_POST['month'], $_POST['day'], $_POST['year']));
			$CurrentPotatoFileName = "potatoes/potato-".$_POST['name'].".xml";
			   $writer = new XMLWriter();  
			   $writer->openURI($CurrentPotatoFileName);   
			   $writer->setIndent(true);
			   $writer->setIndentString("    ");
			   $writer->startElement('xml');  
		       $writer->writeElement('name', $_POST['name']);  
		       $writer->writeElement('startDate', date('l, m/d/Y H:i:s'));
		       $writer->writeElement('goalLaunchDate', $GoalLaunchDate);
		       $writer->writeElement('done', 'no');
		       $writer->writeElement('status', 'Cold');
		       $writer->writeElement('ReleaseManager', $_POST['ReleaseManager']);
		       $writer->writeElement('BuildAndRelease', $_POST['BuildAndRelease']);
		       $writer->writeElement('SiteOps', $_POST['SiteOps']);
		       $writer->writeElement('QA', $_POST['QA']);
		           $writer->startElement('timeline');
		           	$writer->startElement('segment');
			           	$writer->writeElement('team', 'BuildAndRelease');
			           	$writer->writeElement('step', 1);
			           	$writer->writeElement('startDate', date('l, m/d/Y H:i:s'));
			           	$writer->writeElement('endDate', 'N/A');
			           	$writer->writeElement('notes', 'Package Created');
		           	$writer->endElement();
		           
		           $writer->endElement();
		       $writer->endElement();
			   $writer->endDocument();   
			   $writer->flush(); 
			}


if (isset($_GET['currentPotato'])) {
		$CurrentPotato = getCurrentPotato($_GET['currentPotato'], $activePotatoes);
		$TheLastSegment = end(array_values($CurrentPotato->timeLine));
	}
	else {$CurrentPotato = false;}
?>
	<body>
		<div id="wrapper">
			<header>
				<img src="images/logo.png" />
				<h2>Potato</h2>
			</header>
			<div id="PotatoHeader">
				<div id="Version">
					<img src="images/character.png" />
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
						<center>
				    		<form method="post" >
				    		<div id="pass" >
				    		<h2>Create Release <img src="images/potato.png" /></h2>
				    			
				    			Release Name: <input type="text" name="name"><br/>
				    			Goal Launch Date: 

								<?php
								$lowestYear = 2013;
								$highestYear = 2020;
								?>

								<select name="month">
								<?php foreach(range(1,12) as $month): ?> 
								<option value="<?php echo $month;?>"><?php echo  date("F", mktime(0, 0, 0, $month, 10));?></option>
								<?php endforeach ?>
								</select>

								<select name="day">
								<?php foreach(range(1,31)as $day): ?>
								<option value="<?php echo $day;?>"><?php echo $day;?></option> 
								<?php endforeach ?>
								</select>

								<select name="year">
								<?php foreach (range($lowestYear,$highestYear) as $year):?>
								<option value="<?php echo $year;?>"><?php echo $year;?></option>
								<?php endforeach?>
								</select>

								<select name="hour">
								<?php foreach (range(0,23) as $hour):?>
								<option value="<?php echo $hour;?>"><?php echo $hour;?></option>
								<?php endforeach?>
								</select>
								:
								<select name="minute">
								<?php foreach (range(0,50) as $minute):?>
								<option value="<?php echo $minute;?>"><?php echo $minute;?></option>
								<?php endforeach?>
								</select>
								<br/>
								Release Manager Email: <input type="text" name="ReleaseManager"><br/>
								Build &amp; Release Email: <input type="text" name="BuildAndRelease"><br/>
								SiteOps Email: <input type="text" name="SiteOps"><br/>
								QA Email: <input type="text" name="QA"><br/>

								<input type="submit" name="submit" value="Create Release" />
				    		</div>
				    		</form>
				    		</center>
					</div>
				</div>
		</div>

	</body>

</html>

<name>131112.2</name>
    <startDate>Thursday, 12/05/2013 4:10:40</startDate>
    <goalLaunchDate>Monday, 12/13/2013 5:10:21</goalLaunchDate>
    <done>no</done>
    <status>Hot</status>
    <ReleaseManager>Carrie</ReleaseManager>
    <BuildAndRelease>Balaji</BuildAndRelease>
    <SiteOps>Mikal</SiteOps>
    <QA>Chatan</QA>