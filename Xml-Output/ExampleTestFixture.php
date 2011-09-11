<?php
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
    //        Suggested naming is to include the following
    //     [function name][test scenario][expected result]Test
    //     for example, you could use underscores or "with" and "Expect" keywords to construct the name
    //     AddTwoNumbers_3And2_Expect5Test or AddTwoNumbersWith3and2Expect5Test
    // Usage: We recommend using the Arrange, Act, Assert syntax as shown below
    public function AddTwoNumbersWith3and2Expect5Test() {
        // Arrange
        $target = Enhance::getCodeCoverageWrapper('ExampleClass');

        // Act
        $result = $target->AddTwoNumbers(3, 2);

        // Assert
        Assert::areIdentical(5, $result);
    }
    
    // Test
    public function AddTwoNumbersWith4and2Expect6Test() {
        // Arrange
        $target = Enhance::getCodeCoverageWrapper('ExampleClass');

        // Act
        $result = $target->AddTwoNumbers(4, 2);

        // Assert
        Assert::areIdentical(6, $result);
    }
    
    // Test
    // This is an example of a failing test
    public function AddTwoNumbersWith5and5Expect9Test() {
        // Arrange
        $target = Enhance::getCodeCoverageWrapper('ExampleClass');

        // Act
        $result = $target->AddTwoNumbers(5, 5);

        // Assert
        // We deliberately assert the wrong result to show an error
        Assert::areIdentical(9, $result);
    }
}
?>