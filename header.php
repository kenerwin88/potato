<?php
# Enable all errors, we want clean code
error_reporting(E_ALL);
ini_set("display_errors", 1);

# Includes
include 'functions.php';
include 'classes/task.php';
include 'classes/step.php';
include 'classes/potato.php';
include 'classes/segment.php';

# Declare Constants
define('RELEASEDIRECTORY', 'potatoes/');  
define('CURRENTDATE', date('l, m/d/Y H:i:s')); 

# Declare Variables
$done = false; 

# Get Potatoes
$potatoes = getPotatoes();
$activePotatoes = getActivePotatoes($potatoes);
$inactivePotatoes = getInactivePotatoes($potatoes);

?>