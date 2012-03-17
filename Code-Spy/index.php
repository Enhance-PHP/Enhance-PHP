<?php
// Set up the code-coverage reporting
include('codespy.php');
\codespy\Analyzer::$outputdir = 'g:\work\EasyPHP-5.3.6.1\www\output';
\codespy\Analyzer::$outputformat = 'html';
\codespy\Analyzer::$coveredcolor = '#c2ffc2';
//\codespy\Analyzer::addFileToSpy('ExampleClass.php');

// Include the test framework
include('../EnhanceTestFramework.php');

// Find the tests - '.' is the current folder
 \Enhance\Core::discoverTests('.');
// Run the tests
\Enhance\Core::runTests();
?>

