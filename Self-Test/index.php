<?php
// Set up the code-coverage reporting
//include_once('../Code-Spy/codespy.php');
//\codespy\Analyzer::$outputdir = 'C:\Users\Steve Fenton\Documents\_BackedUp\Projects\enhance-php-source\Code-Spy\output';
//\codespy\Analyzer::$outputformat = 'html';
//\codespy\Analyzer::$coveredcolor = '#c2ffc2';

// Include the test framework
include_once('../EnhanceTestFramework.php');

// Find the tests - '.' is the current folder
\Enhance\Core::discoverTests('.', true, array('Exclusion'));
// Run the tests
\Enhance\Core::runTests();
