<?php
// Example built using TDD
include('../EnhanceTestFramework.php');

class ExampleClass 
{
    public function addTwoNumbers($a, $b)
    {
        return $a + $b;
    }
}

class ExampleTestFixture 
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

Enhance::runTests();
?>

