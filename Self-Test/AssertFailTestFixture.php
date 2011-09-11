<?php
class AssertFailTestFixture
 {
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertFailExpectErrorTest()
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