<?php
class Potato
{
    public $name, $status, $startDate, $goalLaunchDate, $timeLine, $done, $office, $targetEnvironment, $applications;

    function __construct($name, $status, $startDate, $goalLaunchDate, $timeLine, $done, $office, $targetEnvironment, $applications)
    {
        $this->name = (string)$name;
        $this->status = (string)$status;
        $this->startDate = (string)$startDate;
        $this->goalLaunchDate = (string)$goalLaunchDate;
        $this->timeLine = $timeLine;
        $this->done = (string)$done;
        $this->office = (string)$office;
        $this->targetEnvironment = (string)$targetEnvironment;
        $this->applications = (string)$applications;
    }

    function getTeamHolding()
    {
        return $this->getLastSegment()->team;
    }

    function getLastSegment()
    {
        $arrayValues = array_values($this->timeLine);
        return end($arrayValues);
    }

    // Returns time in seconds from start date to goal launch date

    function getTimeFromStartToLaunch()
    {
        return secondsToTime($this->getSecondsFromStartToLaunch());
    }

    // Returns time in seconds from start date to now

    function getSecondsFromStartToLaunch()
    {
        return timeDifference($this->goalLaunchDate, $this->startDate);
    }

    // Returns time in human readable format from start date to goal launch date

    function getTimeFromStartToNow()
    {
        return secondsToTime($this->getSecondsFromStartToNow());
    }

    // Returns time in human readable format from start date to NOW

    function getSecondsFromStartToNow()
    {
        return timeDifference(CURRENTDATE, $this->startDate);
    }

    function getInformation()
    {
        $message = file_get_contents("templates/Step-" . $this->getLastSegment()->step . ".html");
        $XML = simplexml_load_file("templates/Step-" . $this->getLastSegment()->step . ".html");
        #print_r($XML->body->table->tr->td->font->div->div->ol);
        #print_r($XML);
        echo $XML->body;
        $data = explode('<!-- data -->', $message);
        $data = explode('<!-- endData -->', $data[1]);

        return populateData($this, $data[0]);

    }
}
