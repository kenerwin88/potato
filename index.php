<?php include 'header.php'; ?>
<?php if ($selectedPotato) { ?>
    <h1>Summary</h1>
    <hr/>
    <?php
        echo $selectedPotato->getInformation();
        $timePassed = timeDifference($selectedPotato->getLastSegment()->startDate, CURRENTDATE);

        #echo secondsToTime($timePassed); ?>
    </b>
    <hr/>
    <br/>
    <center>
    <h3>Timeline</h3>
    <h4>TIMEBAR</h4>
    </center>
    <br/>
    <hr/>
    <h1>Pass the Release</h1>
    <br/>
    <center>
        
    <form method="post">
        <input type="hidden" name="page" value="index"/>

        <div id="pass"
             style="border:2px dotted; border-radius:25px; width: 300px; padding: 10px; text-align:center; margin-left: 0 auto;">
            <h2>Pass <?php echo $selectedPotato->name ?> <img src="images/potato.png" alt="potato"/></h2>
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
            Additional Notes: <br/><textarea name="notes" rows="4" cols="30"></textarea><br/>
            <input type="hidden" name="PotatoVersion" value="<?php echo $Potato->name ?>">
            <input type="submit" name="submit" value="Pass Potato"/>
        </div>
    </form>
    <br/>
    </center>
    <hr/>
    <br/>
    <h1>Debug Info</h1>
    <?php
    echo 'Current Step: <b>', getStep($selectedPotato->getLastSegment()->step) . '</b>';
    echo '<br/>Seconds from Start Date to Launch Date: <b>' . $selectedPotato->getSecondsFromStartToLaunch() . '</b>';
    echo '<br/>Time from Start Date to Launch Date: <b>' . $selectedPotato->getTimeFromStartToLaunch() . '</b>';
    echo '<br/>Seconds from Start Date to Now: <b>' . $selectedPotato->getSecondsFromStartToNow() . '</b>';
    echo '<br/>Time from Start Date to Now: <b>' . $selectedPotato->getTimeFromStartToNow() . '</b>';

    foreach ($selectedPotato->timeLine as $segment) {
        echo '<br/>Segment Time: ' . $segment->getSegmentTime() . '<br/>';
    }

    echo '<br/>Time until launch: <b>';
    echo secondsToTime(timeDifference($selectedPotato->goalLaunchDate, date('1, m/d/Y H:i:s')));
    ?>
    </b>

<?php
} else {
    ?><p>Please select a release.</p><?php
}
?>
<?php include 'footer.php'; ?>