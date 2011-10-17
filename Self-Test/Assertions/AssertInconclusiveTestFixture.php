<?php
class AssertInconclusiveTestFixture extends EnhanceTestFixture
 {
    /** @var EnhanceAssertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions', array(EnhanceLanguage::English));
    }

    public function assertInconclusiveExpectError()
    {
        $verifyFailed = false;
        try {
            $this->target->inconclusive();
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
}
?>