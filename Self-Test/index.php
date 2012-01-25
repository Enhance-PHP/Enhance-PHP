<?php
// Include the test framework
include('../EnhanceTestFramework.php');
// Find the tests - '.' is the current folder
\Enhance\Core::discoverTests('.', true, array('Exclusion'));
// Run the tests
\Enhance\Core::runTests();
?>