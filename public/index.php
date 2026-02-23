<?php

// Front Controller
// Only start session here if needed globally
if (!session_id()) session_start();

// Require the bootstrap file
require_once '../app/init.php';

// Instantiate the App class
$app = new App();
