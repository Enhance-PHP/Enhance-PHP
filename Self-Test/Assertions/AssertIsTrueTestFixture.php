<?php
class AssertIsTrueTestFixture extends EnhanceTestFixture
{
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertIsTrueWithTrueExpectPass()
    {
        $this->target->isTrue(true);
    }
    
    public function assertIsTrueWithFalseExpectFail()
    {
        $verifyFailed = false;
        try {
            $this->target->isTrue(false);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
    
    public function assertIsTrueWith1ExpectFail()
    {
        $verifyFailed = false;
        try {
            $this->target->isTrue(1);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
}
?>