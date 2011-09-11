<?php
class AssertAreNotIdenticalTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertAreNotIdenticalWithDifferentIntegersTest() {
        $this->Target->areNotIdentical(5, 4);
    }
    
    public function AssertAreNotIdenticalWithIdenticalIntegersTest() {
        $VerifyFailed = false;
        try {
            $this->Target->areNotIdentical(5, 5);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function AssertAreNotIdenticalWithDifferentStringsTest() {
        $this->Target->areNotIdentical('Test', 'test');
    }
    
    public function AssertAreNotIdenticalWithIdenticalStringsTest() {
        $VerifyFailed = false;
        try {
            $this->Target->areNotIdentical('Test', 'Test');
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function AssertAreNotIdenticalWithDifferentFloatsTest() {
        $this->Target->areNotIdentical(15.123346575, 15.123346574);
    }
    
    public function AssertAreNotIdenticalWithIdenticalFloatsTest() {
        $VerifyFailed = false;
        try {
            $this->Target->areNotIdentical(15.123346575, 15.123346575);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>