<?php
class AssertIsFalseTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertIsFalseWithFalseExpectPassTest() {
        $this->Target->isFalse(false);
    }
    
    public function AssertIsFalseWithTrueExpectFailTest() {
        $VerifyFailed = false;
        try {
            $this->Target->isFalse(true);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function AssertIsFalseWith0ExpectFailTest() {
        $VerifyFailed = false;
        try {
            $this->Target->isFalse(0);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>