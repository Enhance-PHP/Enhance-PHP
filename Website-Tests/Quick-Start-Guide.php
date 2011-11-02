<?php
// Include the test framework
include_once('EnhanceTestFramework.php');

// Include your classes and test fixtures - they can be in separate files, just use include() statements for them!
class ExampleClass
{
    public function addTwoNumbers($a, $b)
    {
        return $a + $b;
    }
}

// Naming: By using "extends EnhanceTestFixture" you signal that the public methods in
// your class are tests.
class ExampleClassTests extends \Enhance\TestFixture
{

    // SetUp
    // Naming: The method is optional, but if present you must call it "SetUp".
    // Usage: You can use the SetUp method to pre-configure things you want to use in all your tests.
    public function setUp() 
    {

    }
    
    // TearDown
    // Naming: The method is optional, but if present you must call it "TearDown".
    // Usage: You can use the TearDown method to re-set things after all you tests.
    public function tearDown()
    {
    
    }

    // Test
    // You can name tests as you like, but they must be public.
    // All public methods other than setUp and tearDown are treated as tests.
    public function addTwoNumbersWith3and2Expect5Test() 
    {
        // Arrange
        $target = \Enhance\Enhance::getCodeCoverageWrapper('ExampleClass');

        // Act
        $result = $target->addTwoNumbers(3, 2);

        // Assert
        \Enhance\Assert::areIdentical(5, $result);
    }
}

// Run the tests
\Enhance\Enhance::runTests();
?>

