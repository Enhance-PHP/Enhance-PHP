<?php
class AssertIsTrueTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertIsTrueWithTrueExpectPassTest() {
        $this->Target->isTrue(true);
    }
    
    public function AssertIsTrueWithFalseExpectFailTest() {
        $VerifyFailed = false;
        try {
            $this->Target->isTrue(false);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function AssertIsTrueWith1ExpectFailTest() {
        $VerifyFailed = false;
        try {
            $this->Target->isTrue(1);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>