<?php
class AssertAreIdenticalTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertAreIdenticalWithIdenticalIntegersTest() {
        $this->Target->areIdentical(5, 5);
    }
    
    public function AssertAreIdenticalWithDifferentIntegersTest() {
        $VerifyFailed = false;
        try {
            $this->Target->areIdentical(5, 4);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function AssertAreIdenticalWithIdenticalStringsTest() {
        $this->Target->areIdentical('Test', 'Test');
    }
    
    public function AssertAreIdenticalWithDifferentStringsTest() {
        $VerifyFailed = false;
        try {
            $this->Target->areIdentical('Test', 'test');
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function AssertAreIdenticalWithIdenticalFloatsTest() {
        $this->Target->areIdentical(15.123346575, 15.123346575);
    }
    
    public function AssertAreIdenticalWithDifferentFloatsTest() {
        $VerifyFailed = false;
        try {
            $this->Target->areIdentical(15.123346575, 15.123346574);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>