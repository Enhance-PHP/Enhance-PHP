<?php
class AssertAreIdenticalTestFixture
{
    private $target;
    
    public function setUp() 
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertAreIdenticalWithIdenticalIntegersTest()
    {
        $this->target->areIdentical(5, 5);
    }
    
    public function assertAreIdenticalWithDifferentIntegersTest()
    {
        $verifyFailed = false;
        try {
            $this->target->areIdentical(5, 4);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
    
    public function assertAreIdenticalWithIdenticalStringsTest()
    {
        $this->target->areIdentical('Test', 'Test');
    }
    
    public function assertAreIdenticalWithDifferentStringsTest()
    {
        $verifyFailed = false;
        try {
            $this->target->areIdentical('Test', 'test');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
    
    public function assertAreIdenticalWithIdenticalFloatsTest()
    {
        $this->target->areIdentical(15.123346575, 15.123346575);
    }
    
    public function assertAreIdenticalWithDifferentFloatsTest() 
    {
        $verifyFailed = false;
        try {
            $this->target->areIdentical(15.123346575, 15.123346574);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
}
?>