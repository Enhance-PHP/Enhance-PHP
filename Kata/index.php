<?php
// Include the test framework
include_once('../EnhanceTestFramework.php');
// Find the tests - '.' is the current folder
\Enhance\Core::discoverTests('.');
// Run the tests
\Enhance\Core::runTests();
