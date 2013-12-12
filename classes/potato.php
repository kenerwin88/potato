<?php
	class Potato {
		public $name;
		public $status;
		public $lastChanged;
		public $startDate;
		public $goalLaunchDate;
		public $timeLine;
		public $ReleaseManager, $BuildAndRelease, $SiteOps, $QA, $done;

		function __construct($name, $status, $lastChanged, $startDate, $goalLaunchDate, $timeLine, $ReleaseManager, $BuildAndRelease, $SiteOps, $QA, $done) {
			$this->name = (string)$name;
			$this->status = (string)$status;
			$this->lastChanged = (string)$lastChanged;
			$this->startDate = (string)$startDate;
			$this->goalLaunchDate = (string)$goalLaunchDate;
			$this->timeLine = $timeLine;
			$this->ReleaseManager = (string)$ReleaseManager;
			$this->BuildAndRelease = (string)$BuildAndRelease;
			$this->SiteOps = (string)$SiteOps;
			$this->QA = (string)$QA;
			$this->done = (string)$done;
		}

		function getLastSegment() {
			$arrayValues = array_values($this->timeLine);
			return end($arrayValues);
		}

		function getTeamHolding() {
			return $this->getLastSegment()->team;
		}

		function getPersonHolding() {
			$currentTeam = $this->getTeamHolding();
			return $this->{$currentTeam};
		}

		function getPerson($team) {
			return $this->$team;
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
	}
?>