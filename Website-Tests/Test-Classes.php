<?php
// Include the test framework
include('enhance/EnhanceTestFramework.php');
// Include your classes and test fixtures
include('ExampleClass.php');
include('test/ExampleClassTests.php');
// Run the tests
Enhance::runTests();
?>

<?php
class ExampleClassTests extends EnhanceTestFixture
{
        private $target;

        public function setUp()
        {
                $this->target = Enhance::getCodeCoverageWrapper('ExampleClass');
        }

        public function addTwoNumbersWith3and2Expect5Test()
        {
                $result = $this->target->addTwoNumbers(3, 2);
                Assert::areIdentical(5, $result);
        }
        
        public function addTwoNumbersWith4and2Expect6Test()
        {
                $result = $this->target->addTwoNumbers(4, 2);
                Assert::areIdentical(6, $result);
        }
}
?>

