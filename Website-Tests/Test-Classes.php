<?php
// Include the test framework
include_once('../EnhanceTestFramework.php');
// Find the tests - '.' is the current folder
\Enhance\Core::discoverTests('.');
// Run the tests
\Enhance\Core::runTests();

class ExampleClassTests extends \Enhance\TestFixture
{
        private $target;

        public function setUp()
        {
                $this->target = \Enhance\Core::getCodeCoverageWrapper('ExampleClass');
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
