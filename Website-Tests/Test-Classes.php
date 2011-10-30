<?php
// Include the test framework
include('../EnhanceTestFramework.php');
// Find the tests - '.' is the current folder
\Enhance\Enhance::discoverTests('.');
// Run the tests
\Enhance\Enhance::runTests();
?>

<?php
class ExampleClassTests extends \Enhance\EnhanceTestFixture
{
        private $target;

        public function setUp()
        {
                $this->target = \Enhance\Enhance::getCodeCoverageWrapper('ExampleClass');
        }

        public function addTwoNumbersWith3and2Expect5()
        {
                $result = $this->target->addTwoNumbers(3, 2);
                \Enhance\Assert::areIdentical(5, $result);
        }
        
        public function addTwoNumbersWith4and2Expect6()
        {
                $result = $this->target->addTwoNumbers(4, 2);
                \Enhance\Assert::areIdentical(6, $result);
        }
}
?>

