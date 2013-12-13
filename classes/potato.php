<?php
	class Potato {
		public $name, $status, $startDate, $goalLaunchDate, $timeLine, $done, $office, $targetEnvironment, $applications;

		function __construct($name, $status, $startDate, $goalLaunchDate, $timeLine, $done, $office, $targetEnvironment, $applications) {
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

		function getLastSegment() {
			$arrayValues = array_values($this->timeLine);
			return end($arrayValues);
		}

		function getTeamHolding() {
			return $this->getLastSegment()->team;
		}

		// Returns time in seconds from start date to goal launch date
		function getSecondsFromStartToLaunch() {
			return timeDifference( $this->goalLaunchDate, $this->startDate );
		}

		// Returns time in seconds from start date to now
		function getSecondsFromStartToNow() {
			return timeDifference( CURRENTDATE, $this->startDate );
		}

		// Returns time in human readable format from start date to goal launch date
		function getTimeFromStartToLaunch() {
			return secondsToTime($this->getSecondsFromStartToLaunch());
		}

		// Returns time in human readable format from start date to NOW
		function getTimeFromStartToNow() {
			return secondsToTime($this->getSecondsFromStartToNow());
		}

		function getInformation() {
			return 'Llama';
		}
	}
?>