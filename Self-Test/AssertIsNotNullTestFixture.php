<?php
class AssertIsNotNullTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertIsNotNullWithNotNullTest() {
        $this->Target->isNotNull('');
    }
    
    public function AssertIsNotNullWithNullTest() {
        $VerifyFailed = false;
        try {
            $this->Target->isNotNull(null);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>