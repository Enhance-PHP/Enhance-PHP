<?php
// Include the test framework
include('../EnhanceTestFramework.php');
// Set the language
Enhance::setLanguage(EnhanceLanguage::Deutsch);
// Find the tests - '.' is the current folder
Enhance::discoverTests('.');
// Run the tests
Enhance::runTests();
?>