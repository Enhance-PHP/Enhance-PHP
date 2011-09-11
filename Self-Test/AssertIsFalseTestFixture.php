<?php
class AssertIsFalseTestFixture 
{
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertIsFalseWithFalseExpectPassTest()
    {
        $this->target->isFalse(false);
    }
    
    public function assertIsFalseWithTrueExpectFailTest()
    {
        $VerifyFailed = false;
        try {
            $this->target->isFalse(true);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function assertIsFalseWith0ExpectFailTest()
    {
        $verifyFailed = false;
        try {
            $this->target->isFalse(0);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
}
?>