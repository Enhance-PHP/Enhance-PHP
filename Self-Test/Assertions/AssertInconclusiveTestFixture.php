<?php
class AssertInconclusiveTestFixture extends \Enhance\EnhanceTestFixture
 {
    /** @var \Enhance\EnhanceAssertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Enhance::getCodeCoverageWrapper('\Enhance\EnhanceAssertions', array(\Enhance\EnhanceLanguage::English));
    }

    public function assertInconclusiveExpectError()
    {
        $verifyFailed = false;
        try {
            $this->target->inconclusive();
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>