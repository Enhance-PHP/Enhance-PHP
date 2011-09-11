<?php
class AssertIsNullTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertIsNullWithNullTest() {
        $this->Target->isNull(null);
    }
    
    public function AssertIsNullWithNotNullTest() {
        $VerifyFailed = false;
        try {
            $this->Target->isNull('');
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>