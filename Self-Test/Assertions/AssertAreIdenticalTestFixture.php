<?php
class AssertAreIdenticalTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertAreIdenticalWithIdenticalIntegers()
    {
        $this->target->areIdentical(5, 5);
    }
    
    public function assertAreIdenticalWithDifferentIntegers()
    {
        $verifyFailed = false;
        try {
            $this->target->areIdentical(5, 4);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
    
    public function assertAreIdenticalWithIdenticalStrings()
    {
        $this->target->areIdentical('Test', 'Test');
    }
    
    public function assertAreIdenticalWithDifferentStrings()
    {
        $verifyFailed = false;
        try {
            $this->target->areIdentical('Test', 'test');
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
    
    public function assertAreIdenticalWithIdenticalFloats()
    {
        $this->target->areIdentical(15.123346575, 15.123346575);
    }
    
    public function assertAreIdenticalWithIdenticalFloatsAsResultOfAddition()
    {
        $this->target->areIdentical(7.28, 3.14 + 4.14);
    }
    
    public function assertAreIdenticalWithDifferentFloats() 
    {
        $verifyFailed = false;
        try {
            $this->target->areIdentical(15.123346575, 15.123346574);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
