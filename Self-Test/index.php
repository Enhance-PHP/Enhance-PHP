<?php
// Include the test framework
include('../EnhanceTestFramework.php');

// Tests
include('MockTestFixture.php');
include('CodeCoverageLoggerTestFixture.php');
include('ExpectationTestFixture.php');

// Assertion Tests
include('AssertAreIdenticalTestFixture.php');
include('AssertAreNotIdenticalTestFixture.php');
include('AssertContainsTestFixture.php');
include('AssertNotContainsTestFixture.php');
include('AssertIsTrueTestFixture.php');
include('AssertIsFalseTestFixture.php');
include('AssertIsNullTestFixture.php');
include('AssertIsNotNullTestFixture.php');
include('AssertIsInstanceOfTypeTestFixture.php');
include('AssertIsNotInstanceOfTypeTestFixture.php');
include('AssertFailTestFixture.php');
include('AssertInconclusiveTestFixture.php');
include('AssertThrowsTestFixture.php');
include('EnhanceOutputTemplateFactoryTestFixture.php');

// Run the tests
Enhance::runTests();
?>

