<?php
// Include the test framework
include('../EnhanceTestFramework.php');
// Set the language
\Enhance\Core::setLanguage(\Enhance\Language::BrazilianPortuguese);
// Find the tests - '.' is the current folder
 \Enhance\Core::discoverTests('.');
// Run the tests
\Enhance\Core::runTests();
?>
