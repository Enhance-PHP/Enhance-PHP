<?php
class AssertFailTestFixture extends EnhanceTestFixture
 {
    /** @var EnhanceAssertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertFailExpectError()
    {
        $verifyFailed = false;
        try {
            $this->target->fail();
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
}
?>