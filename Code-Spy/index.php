<?php
// Set up the code-coverage reporting
include('codespy.php');
\codespy\Analyzer::$outputdir = 'C:\Users\Steve Fenton\Documents\_BackedUp\Projects\enhance-php-source\Code-Spy\Output';
\codespy\Analyzer::$outputformat = 'html';
\codespy\Analyzer::$coveredcolor = '#c2ffc2';
\codespy\Analyzer::addFileToSpy('ExampleClass.php');

// Include the test framework
include('../EnhanceTestFramework.php');

// Find the tests - '.' is the current folder
 \Enhance\Core::discoverTests('.');
// Run the tests
\Enhance\Core::runTests();
?>

