<?php
class ExampleClassTests extends \Enhance\TestFixture
{
        public function addTwoNumbersWith3and2Expect5Test()
        {
                $target = new ExampleClass();
                $result = $target->addTwoNumbers(3, 2);
                \Enhance\Assert::areIdentical(5, $result);
        }
        
        public function addTwoNumbersWith4and2Expect6Test()
        {
                $target = new ExampleClass();
                $result = $target->addTwoNumbers(4, 2);
                \Enhance\Assert::areIdentical(6, $result);
        }
}
?>

<?php
class ExampleClassTests  extends \Enhance\TestFixture
{
        public function addTwoNumbersWith3and2Expect5Test()
        {
                $target = \Enhance\Core::getCodeCoverageWrapper('ExampleClass');
                $result = $target->addTwoNumbers(3, 2);
                \Enhance\Assert::areIdentical(5, $result);
        }
        
        public function addTwoNumbersWith4and2Expect6Test()
        {
                $target = \Enhance\Core::getCodeCoverageWrapper('ExampleClass');
                $result = $target->addTwoNumbers(4, 2);
                \Enhance\Assert::areIdentical(6, $result);
        }
}
?>

<?php
$target = \Enhance\Core::getCodeCoverageWrapper('ExampleClassWithConstructor', array(1, 'ArgumentTwo'));
?>