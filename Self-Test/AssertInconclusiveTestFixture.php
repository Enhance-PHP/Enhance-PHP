<?php
class AssertInconclusiveTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertInconclusiveExpectErrorTest() {
        $VerifyFailed = false;
        try {
            $this->Target->inconclusive();
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>