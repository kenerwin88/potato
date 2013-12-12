<?php
	class Segment {
		public $team, $step, $startDate, $endDate, $notes;

		function __construct( $team, $step, $startDate, $endDate, $notes ) {
			$this->team = (string)$team;
			$this->step = (string)$step;
			$this->startDate = (string)$startDate;
			$this->endDate = (string)$endDate;
			$this->notes = (string)$notes;
		}
	}
?>