<?php
class AssertAreNotIdenticalTestFixture
 {
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertAreNotIdenticalWithDifferentIntegersTest()
    {
        $this->target->areNotIdentical(5, 4);
    }
    
    public function assertAreNotIdenticalWithIdenticalIntegersTest()
    {
        $verifyFailed = false;
        try {
            $this->target->areNotIdentical(5, 5);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
    
    public function assertAreNotIdenticalWithDifferentStringsTest()
    {
        $this->target->areNotIdentical('Test', 'test');
    }
    
    public function assertAreNotIdenticalWithIdenticalStringsTest()
    {
        $verifyFailed = false;
        try {
            $this->target->areNotIdentical('Test', 'Test');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
    
    public function assertAreNotIdenticalWithDifferentFloatsTest()
    {
        $this->target->areNotIdentical(15.123346575, 15.123346574);
    }
    
    public function assertAreNotIdenticalWithIdenticalFloatsTest()
    {
        $verifyFailed = false;
        try {
            $this->target->areNotIdentical(15.123346575, 15.123346575);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
}
?>