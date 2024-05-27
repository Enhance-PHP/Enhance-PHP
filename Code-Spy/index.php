<?php
// Set up the code-coverage reporting
include_once('codespy.php');
\codespy\Analyzer::$outputdir = 'C:\temp';
\codespy\Analyzer::$outputformat = 'html';
\codespy\Analyzer::$coveredcolor = '#c2ffc2';
\codespy\Analyzer::addFileToSpy('ExampleClass.php');

// Include the test framework
include_once('../EnhanceTestFramework.php');

// Find the tests - '.' is the current folder
 \Enhance\Core::discoverTests('.');
// Run the tests
\Enhance\Core::runTests();
