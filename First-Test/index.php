<?php
// Include the test framework
include('../EnhanceTestFramework.php');
// Set the language
\Enhance\Enhance::setLanguage(\Enhance\EnhanceLanguage::Deutsch);
// Find the tests - '.' is the current folder
 \Enhance\Enhance::discoverTests('.');
// Run the tests
\Enhance\Enhance::runTests();
?>