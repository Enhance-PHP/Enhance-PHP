<?php
class AssertFailTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertFailExpectErrorTest() {
        $VerifyFailed = false;
        try {
            $this->Target->fail();
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>