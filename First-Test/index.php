<?php
// Include the test framework
include('../EnhanceTestFramework.php');
// Find the tests - '.' is the current folder
Enhance::discoverTests('.');
// Run the tests
Enhance::runTests();
?>

