<?php
// Include the test framework
include('../EnhanceTestFramework.php');
// Find the tests - '.' is the current folder
\Enhance\Enhance::discoverTests('.');
// Run the tests
\Enhance\Enhance::runTests();
?>

