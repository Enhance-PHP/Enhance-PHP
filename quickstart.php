<?php
// Include the test framework
include('EnhanceTestFramework.php');

// Include your classes and test fixtures - they can be in separate files, just use include() statements for them!
class ExampleClass {
	public function AddTwoNumbers($a, $b) {
		return $a + $b;
	}
}

// Naming: Each fixture must end with the word "TestFixture".
//     Suggested naming is to include the following
//     [class name]TestFixture
//     for example
//     MyClassTestFixture
class ExampleTestFixture {

	// SetUp
	// Naming: The method is optional, but if present you must call it "SetUp".
	// Usage: You can use the SetUp method to pre-configure things you want to use in all your tests.
	public function SetUp() {

	}
	
	// TearDown
	// Naming: The method is optional, but if present you must call it "TearDown".
	// Usage: You can use the TearDown method to re-set things after all you tests.
	public function TearDown() {
	
	}

	// Test
	// Naming: Each test function must end with the word "Test".
	//		Suggested naming is to include the following
	//     [function name][test scenario][expected result]Test
	//     for example, you could use underscores or "With" and "Expect" keywords to construct the name
	//     AddTwoNumbers_3And2_Expect5Test or AddTwoNumbersWith3and2Expect5Test
	// Usage: We recommend using the Arrange, Act, Assert syntax as shown below
	public function AddTwoNumbersWith3and2Expect5Test() {
		// Arrange
		$target = Enhance::GetCodeCoverageWrapper('ExampleClass');

		// Act
		$result = $target->AddTwoNumbers(3, 2);

		// Assert
		Assert::AreIdentical(5, $result);
	}
}

// Run the tests
Enhance::RunTests();
?>

