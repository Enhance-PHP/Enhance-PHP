<?php
class ExampleClassTests extends EnhanceTestFixture
{
        public function addTwoNumbersWith3and2Expect5Test()
        {
                $target = new ExampleClass();
                $result = $target->addTwoNumbers(3, 2);
                Assert::areIdentical(5, $result);
        }
        
        public function addTwoNumbersWith4and2Expect6Test()
        {
                $target = new ExampleClass();
                $result = $target->addTwoNumbers(4, 2);
                Assert::areIdentical(6, $result);
        }
}
?>

<?php
class ExampleClassTests  extends EnhanceTestFixture
{
        public function addTwoNumbersWith3and2Expect5Test()
        {
                $target = Enhance::getCodeCoverageWrapper('ExampleClass');
                $result = $target->addTwoNumbers(3, 2);
                Assert::areIdentical(5, $result);
        }
        
        public function addTwoNumbersWith4and2Expect6Test()
        {
                $target = Enhance::getCodeCoverageWrapper('ExampleClass');
                $result = $target->addTwoNumbers(4, 2);
                Assert::areIdentical(6, $result);
        }
}
?>

<?php
$target = Enhance::getCodeCoverageWrapper('ExampleClassWithConstructor', array(1, 'ArgumentTwo'));
?>