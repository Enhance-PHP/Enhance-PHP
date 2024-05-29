<?php

include_once('../EnhanceTestFramework.php');
// Include your classes and test fixtures - they can be in separate files, just use include_once() statements for them!

class ExampleClass
{
    public function addTwoNumbers($a, $b)
    {
        return $a + $b;
    }
}
// Naming: By using "extends \Enhance\TestFixture" you signal that the public methods in // your class are tests.

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
}

Enhance\Core::runTests();
